<?php


// include '../includes/core/config.php';
// Import PHPMailer classes into the global namespace 
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception; 

require 'C:\xampp\htdocs\oop_social\includes\libraries\PHPMailer\src\Exception.php'; 
require 'C:\xampp\htdocs\oop_social\includes\libraries\PHPMailer\src\PHPMailer.php'; 
require 'C:\xampp\htdocs\oop_social\includes\libraries\PHPMailer\src\SMTP.php'; 


class SignUpContr extends SignUp {


	private $FirstName;
	private $LastName;
	private $Username;
	private $Email;
	private $Password;
	private $Password2;
	private $Gender;
	private $client_ip;
	private $token;


	public function __construct($FN,$LN,$UN,$EM,$PA,$PA2,$GN,$IP){

		$this->FirstName = $FN;
		$this->LastName = $LN;
		$this->Username = $UN;
		$this->Email = $EM;
		$this->Password = $PA;
		$this->Password2 = $PA2;
		$this->Gender = $GN;
		$this->client_ip = $IP;
		$this->token = bin2hex(random_bytes(50));   // generate a unique random token of length 100
	}


	public function CreateUser(){

		$error;

		if ($this->emptycheck() == false){

			$error = 'empty parameters';
			return $error;
			exit();
		}

		if ($this->ValidateUser() == false){

			$error = 'AlphaNumeric Characters Only Allowed in the username and min 4 chars';
			return $error;
			exit();
		}

		if ($this->ValidateName() == false){

			$error = 'AlphaNumeric Characters Only Allowed in the name';
			return $error;
			exit();
		}

		if ($this->ValidateEmail() == false){

			$error = 'Invalid Email';
			return $error;
			exit();
		}

		if ($this->CheckUser($this->Username) == true){

			$error = "Username Already Exists";
			return $error;
			exit();
		}
		if ($this->CheckEmail($this->Email) == true){

			$error = " Email Already Exists";
			return $error;
			exit();
		}

		if ($this->MatchPassword() == false){

			$error = "Passwords Don't Match";
			return $error;
			exit();
		}
		if ($this->ValidatePassword() == false){

			$error = "Passwords must contain at least [1 upper/lower case , 1 number , and > 8 char]";
			return $error;
			exit();
		}


		if (empty($error)){

			$this->InsertUser($this->FirstName,$this->LastName,$this->Username,$this->Email,$this->Password,$this->Gender,0,$this->client_ip);
			
			$this->InsertGroups($this->Username,0,'User');

			$this->InsertToken($this->Email,$this->token);


		} 

		return false;
		
		  		
	}

	public function SendEmail($email){
		 
		 
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
		$mail->Subject = 'Account Activation Email'; 
		 
		// Mail body content 
		$output='<html>';
		$output.='<p>Dear user,</p>';
		$output.='<p>Please click on the following link to Activate Your Account</p>';
		$output.='<p>-------------------------------------------------------------</p>';
		$output = '<h1>Hi Please Verify Your account by click on that clink <a href="http://localhost/oop_social/forget-password/reset.php?verify_token='.$this->token.'">Link</a> </h1>'; 
		$output .= '<p>This HTML email is sent from the localhost server using PHPMailer by <b>Pentest Project</b></p>'; 
		$output.='<p>Thanks,</p>';
	    $output.='<p>Pentest Team</p>';
		$output.='</html>';

		$mail->Body    = $output; 


		// Add attachments
		//$mail->addAttachment('/var/tmp/file.tar.gz');
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name
		 
		// Send email 
		if(!$mail->send()) { 
		    $msg =  'Message could not be sent. Mailer Error: '.$mail->ErrorInfo; 
		} else { 
		    $msg = '
	            <p class="lead">please activate your account via the email sent to you.</p>
	            <a class="btn btn-lg btn-success" href="http://localhost/oop_social/verify_account.php?verify_token='.$this->token.'">Click here to Verify your account</a>';

		} 
		 
		 
		return $msg;

	}

	private function emptycheck(){
		
		$results;
		
		if (empty($this->FirstName) || empty($this->LastName) || empty($this->Username) || empty($this->Email) || empty($this->Password) ||  empty($this->Password2) || empty($this->Gender) ) {

			$results = false;
		}
		else {
			$results = true;
		}
	
		return $results;

	}

	private function ValidateUser(){

		$result;

		if ( !preg_match('/^[A-Za-z][A-Za-z0-9]{3,31}$/', $this->Username) ) {

			$result = false;
		}
		else {
			$result = true;
		}

		return $result;

	}

	private function ValidateName(){

		$result;

		if ( !preg_match("/^[a-zA-Z-' ]*$/",$this->FirstName) || !preg_match("/^[a-zA-Z-' ]*$/",$this->LastName) ) {

			$result = false;
		}
		else {
			$result = true;
		}

		return $result;

	}

	private function ValidateEmail(){


		$result;

		if ( !filter_var($this->Email, FILTER_VALIDATE_EMAIL) ) {

			$result = false;
		}
		else {
			$result = true;
		}

		return $result;
		
	}

	private function MatchPassword(){


		$result;

		if ( $this->Password !== $this->Password2  ) {

			$result = false;
		}
		else {
			$result = true;
		}

		return $result;
		
	}

	private function ValidatePassword(){

		$result;
		$uppercase = preg_match('@[A-Z]@', $this->Password);
		$lowercase = preg_match('@[a-z]@', $this->Password);
		$number    = preg_match('@[0-9]@', $this->Password);

		if(!$uppercase || !$lowercase || !$number || strlen($this->Password) < 8) {
		  $result = false;
		}
		else {

			$result = true;
		}

		return $result;
		
	}



   





}










?>