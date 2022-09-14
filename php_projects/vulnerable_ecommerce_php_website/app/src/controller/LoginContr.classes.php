<?php
namespace Ecommerce\Controller\Auth; 
use Ecommerce\Model\Auth\Login;

use Ecommerce\Core\Traits\Validation; 
use Ecommerce\Core\Traits\Token; 
use Ecommerce\Core\Traits\Session; 

class LoginContr extends Login {

	use Validation,Token,Session;

	Private $Email;
	Private $Password;
	Private $RememberMe;
	Private $Client_ip; 
	Private $useragent;


	// SignIn Methods
 
	Public function SetParams($email,$password,$RememberMe,$Client_ip,$useragent){

		$this->Email 	  = $email; 
		$this->Password   = $password; 
		$this->RememberMe = $RememberMe;
		$this->Client_ip  = $Client_ip; 
		$this->$useragent = $useragent;

	}

	Public function SignInUser($Email){

		$Result = $this->loginCheck();

		if ($Result == 1){
			
			$Username = $this->GetUsername($Email);
			$this->ResetFailedLogin($Email);

			// session_regenerate_id(); // Prevent Session Fixation
			$_SESSION['username'] = $Username;

			if ($this->MFAuthentication($Email) === True){

				if ($this->RememberMe == 'True'){
					//$Username = $this->GetUsername($Email);
					$_SESSION['mfacookie'] = True;
					$_SESSION['mfacookieip'] = $this->Client_ip;
				}

				$_SESSION['mfa'] = True;
				header("Location: 2fa.php");
				exit();
			}
			else {

				if ($this->RememberMe == 'True'){
					//$Username = $this->GetUsername($Email);
					$this->AssignCookie($Username,$this->Client_ip);


					/* insecure Deserialization
					
					$Userobj = new User();

					$UserToken = $this->hashCookie($Username,$this->Client_ip);
					$Userobj->Username = $Username;
					$Userobj->UserToken = $UserToken;

					$data = serialize($Userobj);
					echo $data; */
				}

				 $this->RedirectLoggedUser($Email);
				
			}

			
			
		}
		else {
			return $Result;
		}	

	}

	Private function RedirectLoggedUser($Email){


		if ($this->CheckAccountPriv($Email) == True){

			$_SESSION['loggedin'] = True;
			$_SESSION['isadmin'] = True;
			header('Location: admin/dashboard.php');
			exit;
		}
		else {

			$_SESSION['loggedin'] = True;

			if (isset($_SESSION['redirect_after_login'])){

				//header('Location: '.$_SESSION['redirect_after_login']);

				header('Location: '.$_GET['redirect']);     // Open Redirect dependent on Action

				//header('Location: '.$_SERVER['referer']);     // Open Redirect via referer header
				unset($_SESSION['redirect_after_login']);
				exit;
			}
			else {

				header('Location: index.php');
				exit;
			}
			
			

		}

	}

	Private function loginCheck(){

		if ($this->EmptyCheck($this->Email,$this->Password) == False){

			return 'Please all fields are required';
			exit();

		}

		if ($this->CheckEmailDB($this->Email) == False){

			return 'Wrong Email ';
			// return 'Wrong Email Or Password';  // Prevent Email Enumeration via Response
			exit();

		}

		if ($this->CheckPass($this->Email,$this->Password) == False){

			$time = time();
			$this->InsertFailedLogin($this->Email,$time);

			# Log Action
			$filename= 'log.txt';
			$log= 'Login Failed Attempt From '.$this->Email;
			log_actions($filename,$this->Client_ip,$this->useragent,$log);

			if ($this->CheckAccountLockout($this->Email,$this->Client_ip,$this->useragent)){

				# Log Action
				$filename= 'log.txt';
				$log= 'User '.$this->Email.' Account has been Locked For 15 mins';
				log_actions($filename,$this->Client_ip,$this->useragent,$log);

				return 'Wrong Password , Account Has Been Locked For 15 mins';
			}
			else {

				return 'Wrong Password';
				// return 'Wrong Email Or Password';  // Prevent Email Enumeration via Response
			}

			
			exit();
			
		}

		if ($this->GetAccountStatus($this->Email) == False){

			return 'Please Activate Your account First';
			exit(); 
			
		}

		if ($this->CheckAccountLockout($this->Email,$this->Client_ip,$this->useragent)){

			# Log Action
            $filename= 'log.txt';
            $log= 'Attempt to access Locked Account For User '.$this->Email;
            log_actions($filename,$this->Client_ip,$this->useragent,$log);

			return'Account Locked wait For 15 mins For your next Login';
			exit();
			
		}

		return 1;

    }

    Private function CheckAccountPriv($Email){

    	$AccountPriv = $this->GetAccountPriv($Email);

    	if ($AccountPriv == 0 ){

    		return False;
    	}
    	else {
    		return True;
    	}

    }

	Private function EmptyCheck($Email,$Password){

  		$results;

		if (empty($Email) == True  || empty($Password) == True ){
			
			$results = False;
		}
		else {
			$results = True;
		}
	
		return $results;

    }

    Public function Logout(){

		session_unset();
		session_destroy();

		if(isset($_COOKIE['usersession'])) {

			$cookie = $_COOKIE['usersession'];
			$email = $this->GetEmailByToken($cookie);
			$this->DeleteToken($email);
	        
	        setcookie("usersession","",time()- (90 * 365 * 24 * 60 * 60), "/");
	      //setcookie("loggedin", "");
		}



		header('Location: index.php');
		exit();
		
	}



    // 2 Factor Authentication Methods

	Public function MFALogin($username,$code){

		$User_Code = $code;

		if(empty($User_Code) == True){
			return 'MFA Token Field Is Required';
			exit();

		}

		if ($this->CheckMFACodeDB($code) == False){

			return 'MFA Token Not Found';
			exit();

		}

		$email = $this->GetEmailByUsername($username);

		if ($this->CheckMFACodeExpiry($code) == False){

			$this->DeleteMFACode($email);
			unset($_SESSION['mfa']);
			return 'MFA Token Expired';
			exit();

			}

		$DB_Code = $this->GetMFACodeByEmail($email);

		if ($DB_Code === $User_Code){

				unset($_SESSION['mfa']);
				$this->DeleteMFACode($email);

				if ($_SESSION['mfacookie'] === True){
					//$Username = $this->GetUsername($Email);

					echo $_SESSION['mfacookie'];
					echo $_SESSION['mfacookieip'];
					$this->AssignCookie($username,$_SESSION['mfacookieip']);
				}

				$this->RedirectLoggedUser($email);

		}
		else {

			return 'Login Error Please Use a Valid Code';
			exit();
		}

	}

	Private function MFAuthentication($Email){

		$MFA = $this->CheckEnabledMFA($Email);

		if ($MFA == True){

			$code = $this->GenerateMFCode();
			$this->InsertMFACode($Email,$code);
			$this->SendMFAEmail($Email,$code);
			return True;
		}
		else {

			return False;

		}
		
	}

	Private function SendMFAEmail($email,$code){
		 
		// Mail subject 
		$Subject = '2 Step Verification Email'; 
		 
		// Mail body content 
		$output='<html>';
		$output.='<p>Dear '.$email.',</p>';
		$output.='<h1>Hi Please Use this Code For 2 Step Verification account </h1>'; 
		$output.= '<h1>'.$code.'</h1>'; 
		$output.= '<p>This HTML email is sent from the localhost server using PHPMailer by <b>Ecommerce Project</b></p>'; 
		$output.='<p>Thanks,</p>';
	    $output.='<p>Ecommerce Team</p>';
		$output.='</html>';

		$Body    = $output; 

		$result = SendEmail($email,$Body,$Subject);

		if( $result == 1) {

			return  '<p class="lead">Dear '.$email.' Hi Please Use this Code For 2 Step Verification account</p>
	            <p class="btn btn-lg btn-success" >'.$code.'</p>';

		} else {
			return $result;
		}
		    	
	}

	Private function GenerateMFCode(){

		  return rand(100000, 999999);
		  
	}




}


/*
class User {

	Public $Username;
	Public $UserToken;

}

*/

?>
