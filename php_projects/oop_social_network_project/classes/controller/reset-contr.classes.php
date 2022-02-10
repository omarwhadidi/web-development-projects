<?php

// Import PHPMailer classes into the global namespace 
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception; 

require 'C:\xampp\htdocs\oop_social\includes\libraries\PHPMailer\src\Exception.php'; 
require 'C:\xampp\htdocs\oop_social\includes\libraries\PHPMailer\src\PHPMailer.php'; 
require 'C:\xampp\htdocs\oop_social\includes\libraries\PHPMailer\src\SMTP.php'; 

class ResetContr extends Reset {
 

	private $email;
	private $token;


	public function SetEmail($email){

		$this->email = $email;
		
	}
	public function SetToken(){

		$this->token = bin2hex(random_bytes(50));  // generate a unique random token of length 50
		
	}


	private function EmptyEmailField(){
		
		$results;
		
		if (empty($this->email) ) {

			$results = false;
		}
		else {
			$results = true;
		}
	
		return $results;

	}

	public function GetResetLink(){
		
		$errors;
		
		if ($this->EmptyEmailField() == false)  {

			$errors = '<div class="card-body alert alert-danger" style="">Please Enter your Email</div>';

		}
		
		if (!empty($errors)){

			return $errors;
			exit;
		}
		else{

			$result;

			if (!$this->CheckEmail($this->email)){

				$sub = 'Registeration Email';
				// Mail body content 
			    $output='<html>';
			    $output.='<p>Dear user,</p>';
			    $output.='<p>Please click on the following link to Register an account.</p>';
			    $output.='<p>-------------------------------------------------------------</p>';
			    $output.='<p><a href="http://localhost/oop_social/register.php?action=register" target="_blank">http://localhost/oop_social/register.php?action=register</a></p>';   
			    $output.='<p>-------------------------------------------------------------</p>';
			    $output.='<p>Please be sure to copy the entire link into your browser.</p>';
			    $output.='<p>If you did not request this Registration email, no action 
			    is needed, Please forget this email. However, if you may want to Register  
			    an account please use the link above.</p>';    
			    $output.='<p>Thanks,</p>';
			    $output.='<p>Pentest Team</p>';
			    $output.='</html>';
				$msg = $output;

				$result = $this->SendEmail($this->email,$msg,$sub);

				$msg = '
	            <p class="alert alert-success">An email has been sent to you . Please check your email </p>
	            <p><a class="btn btn-lg btn-success" href="http://localhost/oop_social/register.php?action=register" target="_blank">http://localhost/oop_social/register.php?action=register</a></p>';

	           	if ($result ==True){

					return $msg;
				}
				else {

					echo False;
				}

			}
			else {
				
				$sub = 'Password Reset Email';
				// Mail body content 
			    $output='<html>';
			    $output.='<p>Dear user,</p>';
			    $output.='<p>Please click on the following link to reset your password.</p>';
			    $output.='<p>-------------------------------------------------------------</p>';
			    $output.='<p><a href="http://localhost/oop_social/forget-password/reset.php?
			    token='.$this->token.'&action=reset" target="_blank">http://localhost/oop_social/forget-password/reset-password.php?token='.$this->token.'&action=reset</a></p>';   
			    $output.='<p>-------------------------------------------------------------</p>';
			    $output.='<p>Please be sure to copy the entire link into your browser.
			    The link will expire after 1 day for security reason.</p>';
			    $output.='<p>If you did not request this forgotten password email, no action 
			    is needed, your password will not be reset. However, you may want to log into 
			    your account and change your security password as someone may have guessed it.</p>';    
			    $output.='<p>Thanks,</p>';
			    $output.='<p>Pentest Team</p>';
			    $output.='</html>';
				$msg = $output;

				$result = $this->SendEmail($this->email,$msg,$sub);
				$this->InsertToken($this->email,$this->token);

				$msg = '
	            <p class="alert alert-success">An email has been sent to you . Please check your email </p>
	            <p><a class="btn btn-lg btn-success" href="http://localhost/oop_social/forget-password/reset.php?token='.$this->token.'&action=reset" target="_blank">http://localhost/project1/forget-password/reset-password.php?token='.$this->token.'&action=reset</a></p>';

	            if ($result ==True){

					return $msg;
				}
				else {

					echo False;
				}

			}

		

		}

		
			
		

	}


	private function SendEmail($email,$msg,$sub){
		 
		 
		$mail = new PHPMailer; 
		 
		$mail->isSMTP();                      // Set mailer to use SMTP 
		$mail->Host = 'smtp.gmail.com';       // Specify main and backup SMTP servers 
		$mail->SMTPAuth = true;               // Enable SMTP authentication 
		$mail->Username = 'omarwhadidi9@gmail.com';   // SMTP username 
		$mail->Password = 'yowbupmglklbhvon';   // SMTP password 
		$mail->SMTPSecure = 'tls';            // Enable TLS encryption, `ssl` also accepted 
		$mail->Port = 587;                    // TCP port to connect to 
		 
		// Sender info 
		$mail->setFrom('omarwhadidi9@gmail.com', 'Pentest'); 
		//$mail->addReplyTo('reply@codexworld.com', 'CodexWorld'); 
		 
		// Add a recipient 
		$mail->addAddress($email); 
		 
		//$mail->addCC('cc@example.com'); 
		//$mail->addBCC('bcc@example.com'); 
		 
		// Set email format to HTML 
		$mail->isHTML(true); 
		 
		// Mail subject 
		$mail->Subject = $sub; 
		 


		$mail->Body    = $msg; 


		// Add attachments
		//$mail->addAttachment('/var/tmp/file.tar.gz');
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name
		 
		// Send email 
		if(!$mail->send()) { 
			$msg =  'Message could not be sent. Mailer Error: '.$mail->ErrorInfo; 
		}
		else { 
		    $msg = '
	            <p class="lead">An email has been sent to you . Please check your email </p>
	            <p><a class="btn btn-lg btn-success" href="http://localhost/oop_social/forget-password/reset.php?token='.$this->token.'&action=reset" target="_blank">http://localhost/project1/forget-password/reset-password.php?token='.$this->token.'&action=reset</a></p>';

		} 
		 
		return $msg;

	}

	

	// Reset.php Page Functions

	Private function EmptyNewPass($new1,$new2){

		if (empty($new1) || empty($new2) ){

			return false;
		}
		else {

			return true;
		}
	
	}

	Private function MatchNewPass($new1,$new2){

		if ($new1 !== $new2){

			return false;
		}
		else {

			return true;
		}

	}

	Private function ValidateNewPass($new1){

		$result;
		$uppercase = preg_match('@[A-Z]@', $new1);
		$lowercase = preg_match('@[a-z]@', $new1);
		$number    = preg_match('@[0-9]@', $new1);

		if(!$uppercase || !$lowercase || !$number || strlen($new1) < 8) {
		  $result = false;
		}
		else {

			$result = true;
		}

		return $result;
		
	}

	Private function CheckNewPass($new1,$new2){

		$errors;

		if (!$this->MatchNewPass($new1,$new2)){

			$errors = "Passwords Does'nt Match";
		}

		if (!$this->ValidateNewPass($new1)){

			$errors = "weak Password";
		}
		/*		if (!$this->CheckCurrentPass($this->email,$currentpass)){

					$errors = "Wrong Current Password";
				}*/

		if (!$this->EmptyNewPass($new1,$new2)){

			$errors = "All Fields Are Required";
		}

		if (!empty($errors)){

			return $errors;
		}
		else {

			return false;
		}

	}

	public function ResetUser($newpassword,$newpassword2){

		$check = $this->CheckNewPass($newpassword,$newpassword2);

		if (!$check){

			$hashedpwd = password_hash(hash('sha512', $newpassword), PASSWORD_DEFAULT);

			$this->UpdatePassword($this->email,$hashedpwd);	
			
			$this->DeleteToken($this->email);
			return 'Password Updated SuccessFully <a href="../index.php">Login</a>';
		}
		else {
			return $check;

		}

	}

}

?>