<?php
namespace Ecommerce\Controller\Auth;
use Ecommerce\Model\Auth\SignUp;

use Ecommerce\Core\Traits\Validation; 
use Ecommerce\Core\Traits\Token; 

class SignUpContr extends SignUp {

	use Validation,Token;

	Private $Name;
	Private $Username;
	Private $Email;
	Private $Password;
	Private $ConfirmPassword;
	Private $Client_ip; 
	Private $useragent;
	Private $Token;

	Public function SignUpProcess($name,$username,$email,$password,$confirmpassword,$Client_ip,$useragent){

		$this->Name =  $name; 
		$this->Username =  $username; 
		$this->Email =  $email; 
		$this->Password =  $password; 
		$this->ConfirmPassword =  $confirmpassword; 
		$this->Client_ip =  $Client_ip; 
		$this->$useragent = $useragent;
		$this->Token = Generate_Token();
		
		return $this->CreateUser();

	}

	Private function CreateUser(){

		if ($this->SignupCheck() === True){

			$this->InsertUser($this->Name, $this->Username , $this->Email , $this->Password , $this->Client_ip);
			$this->InsertGroups($this->Email , 0 , 'users');
			$this->InsertToken($this->Email,$this->Token);


			# Log Action
			$filename= 'infolog.txt';
			$log= 'User '.$this->Username.' Created Succesfully';
			log_actions($filename,$this->Client_ip,$this->useragent,$log);

			return $this->SendVerificationEmail();
		}
		else {
			return $this->SignupCheck();
		}

	}

	Private function SignupCheck(){


		if ($this->EmptyCheck() == False){

			return '<div class="alert alert-danger"> Please all Inputs are Required </div>';
			exit();

		}

		if ($this->ValidateName($this->Name) == False){

			return '<div class="alert alert-danger"> Please enter a Valid Name With </div>';
			exit();
		}

/*		if ($this->ValidateUsername($this->Username) == False){  // SELF XSS

			return '<div class="alert alert-danger"> Please Only Letters & Numbers are Allowed in UserName Field </div>';
			exit();
		}*/

		if ($this->validateEmail($this->Email) == 0){
			return '<div class="alert alert-danger"> Please Enter a valid Email </div>';
			exit();

		} 


		if ($this->CheckUserDB($this->Username)){
			return '<div class="alert alert-danger"> Username Exists </div>';
			exit();

		}

		if ($this->CheckEmailDB($this->Email)){
			return '<div class="alert alert-danger">Email Exists </div>';
			exit();
		}

		if ($this->MatchPassword($this->Password,$this->ConfirmPassword) == False){
			return '<div class="alert alert-danger">Passwords Doesnt match </div>';
			exit();

		}


		return True;
		
	}

	Private function EmptyCheck(){

		$results;

		if (empty($this->Name) == True || empty($this->Username) == True || empty($this->Email) == True  || empty($this->Password) == True   || empty($this->ConfirmPassword) == True ){
			
			$results = False;
		}
		else {
			$results = True;
		}
	
		return $results;

	}

	Private function SendVerificationEmail(){
		 
		// Mail subject 
		$Subject = 'Account Activation Email'; 
		 
		// Mail body content 
		$output='<html>';
		$output.='<p>Dear '.$this->Name.',</p>';
		$output.='<p>Please click on the following link to Activate Your Account</p>';
		$output.='<p>-------------------------------------------------------------</p>';
		$output = '<h1>Hi Please Verify Your account by click on that clink <a href="http://localhost:8000/verify-account.php?verify_token='.$this->Token.'">Link</a> </h1>'; 
		$output .= '<p>This HTML email is sent from the localhost server using PHPMailer by <b>Pentest Project</b></p>'; 
		$output.='<p>Thanks,</p>';
	    $output.='<p>Pentest Team</p>';
		$output.='</html>';

		$Body    = $output; 

		$result = SendEmail($this->Email,$Body,$Subject);

		if( $result == 1) {

			return  '<div class="alert alert-success">
						<p class="lead">Dear '.$this->Name.' please Activate your account via the email sent to you.</p>
	            		<a class="btn btn-lg btn-success" href="http://localhost:8000/verify-account.php?verify_token='.$this->Token.'">Click here to Verify your account</a>
	            	</div>';

		} else {
			return $result;
		}
		    	
	}

	Public function ActivateAccount($token){

		$result = $this->CheckTokenDB($token);

		if ($result){

		 $email = $this->GetEmailByToken($token);
		 $this->UpdateAccountStatus($email);
		 $this->DeleteToken($email);

		 return True;

		}
		else {

		 return False;

		}

    } 

    Public function CaptchaCheck(){

   		$secret = '6LfllAAeAAAAAEt_EiW5f53wbftGYyPQShQRdMdn';
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        
        if($responseData->success){

        	return True;
        }
        else {

        	return False;

        }

    }

}






?>
