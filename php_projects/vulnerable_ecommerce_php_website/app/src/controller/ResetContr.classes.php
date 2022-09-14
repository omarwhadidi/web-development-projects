<?php
namespace Ecommerce\Controller\Auth;
use Ecommerce\Model\Auth\Reset;

use Ecommerce\Core\Traits\Validation; 
use Ecommerce\Core\Traits\Token; 

class ResetContr extends Reset{

	use Validation,Token;

	Private $email;
	Private $token;
	
	// forget-password.php Page Methods

	Public function GetResetLink($email){
		
		$this->SetToken();
		$this->SetEmail($email);

		if ($this->EmptyEmailCheck($this->email) == false)  {

			return  '<div class="alert alert-danger">Please Enter your Email</div>';
			exit();

		}
		
		$result;

		if (!$this->CheckEmailDB($this->email)){

			$sub = 'Registeration Email';
			// Mail body content 
		    $output='<html>';
		    $output.='<p>Dear user,</p>';
		    $output.='<p>Please click on the following link to Register an account.</p>';
		    $output.='<p>-------------------------------------------------------------</p>';
		    $output.='<p><a href="http://localhost/ecommerce/public/register.php?action=register" target="_blank">http://localhost/ecommerce/public/register.php?action=register</a></p>';   
		    $output.='<p>-------------------------------------------------------------</p>';
		    $output.='<p>Please be sure to copy the entire link into your browser.</p>';
		    $output.='<p>If you did not request this Registration email, no action 
		    is needed, Please forget this email. However, if you may want to Register  
		    an account please use the link above.</p>';    
		    $output.='<p>Thanks,</p>';
		    $output.='<p>Pentest Team</p>';
		    $output.='</html>';
			$msg = $output;

			$result = SendEmail($this->email,$msg,$sub);

			$msg = '
            <p class="alert alert-success">An email has been sent to you . Please check your email </p>
            <p>Just For Debugging: <a class="btn btn-lg btn-success" href="http://localhost/ecommerce/public/register.php?action=register" target="_blank">http://localhost/ecommerce/public/register.php?action=register</a></p>';

           	if ($result == True){

				return $msg;
			}
			else {

				return False;
			}

		}
		else {
			$host = "http://".$_SERVER['HTTP_HOST']; // Password Reset Poisoning
			$SecureHost = "http://localhost"; 
			$sub = 'Password Reset Email';
			// Mail body content 
		    $output='<html>';
		    $output.='<p>Dear user,</p>';
		    $output.='<p>Please click on the following link to reset your password.</p>';
		    $output.='<p>-------------------------------------------------------------</p>';
		    $output.='<p><a href="'.$host.'/reset-password.php?token='.$this->token.'&action=reset" target="_blank">http://localhost:8000/reset-password.php?token='.$this->token.'&action=reset</a></p>';   
		    $output.='<p>-------------------------------------------------------------</p>';
		    $output.='<p>Please be sure to copy the entire link into your browser.
		    The link will expire after 1 day for security reason.</p>';
		    $output.='<p>If you did not request this forgotten password email, no action 
		    is needed, your password will not be reset. However, you may want to log into 
		    your account and change your security password as someone may have guessed it.</p>';    
		    $output.='<p>Thanks,</p>';
		    $output.='<p>Ecommerce Team</p>';
		    $output.='</html>';
			$msg = $output;

			$result = SendEmail($this->email,$msg,$sub);
			$this->InsertToken($this->email,$this->token);

			$msg = '
            <p class="alert alert-success">An email has been sent to you . Please check your email </p>
            <p>Just For Debugging: <a class="btn btn-lg btn-success" href="'.$host.'/reset-password.php?token='.$this->token.'&action=reset" target="_blank">http://localhost:8000/reset-password.php?token='.$this->token.'&action=reset</a></p>';

            if ($result ==True){

				return $msg;
			}
			else {

				return False;
			}

		}
		
	}

	Private function EmptyEmailCheck($email){
		
		$results;
		
		if (empty($email) ) {

			$results = false;
		}
		else {
			$results = true;
		}
	
		return $results;

	}

	Private function SetToken(){

		$this->token = Generate_Token();
		
	}

	Private function SetEmail($email){

		$this->email = $email;
		
	}


	// Reset.php Page Methods

	Public function ValidateResetToken($token){

		if ($this->CheckTokenDB($token) == False){

			return 'Wrong Token Provided';
			exit();
		}
		 
		if ($this->CheckTokenExpiry($token) == False){

			$email = $this->GetEmailByToken($token);
			$this->DeleteToken($email);
		 	return 'Token Epired';
		 	exit();
		}

		return True;

    }

    Public function GetEmailFromToken($token){

	    	$email = $this->GetEmailByToken($token);
			return $email;

    }

	Public function ResetUser($email,$newpassword,$newpassword2,$Client_ip,$useragent){

		$check = $this->CheckNewPass($newpassword,$newpassword2,$email);

		if ($check == 1){

			$this->UpdatePassword($email,$newpassword);	
			
			$this->DeleteToken($email);

			# Log Action
			$filename= 'infolog.txt';
			$log= 'Password Reset For User '.$email.' Succesfully';
			log_actions($filename,$Client_ip,$useragent,$log);

			return '<div class="alert Alert-Success">Password Updated SuccessFully <a href="register.php">Login</a> </div>';
		}
		else {
			return $check;

		}

	}

	Private function CheckNewPass($new1,$new2,$email){

		if ($this->CheckEmptyFields($new1,$new2) == False){

			return '<div class="alert Alert-danger">All Fields Are Required </div>';
			exit();
		}

		if ($this->MatchPassword($new1,$new2) == False){

			return '<div class="alert Alert-danger"> Passwords Doesnt Match </div>';
			exit();
		}

		if ($this->PasswordPolicy($new1) == False){

			return '<div class="alert Alert-danger"> weak Password provided</div>';
			exit();
		}

		if ($this->CheckOldPassword($new1,$email) == True){

			return  '<div class="alert Alert-danger"> Please Choose a new Password</div>';
			exit();
		}

		return 1;

	}

	Private function CheckOldPassword($newpass,$email){

		$OldPass = $this->GetOldPassword($email);
		
		$verify = password_verify(hash('sha512', $newpass), $OldPass);

		if ($verify == True){

			return True;
		}
		else {

			return False;
		}

	}

	Private function CheckEmptyFields($new1,$new2){

		if (empty($new1) || empty($new2) ){

			return false;
		}
		else {

			return true;
		}
	
	}

}



?>
