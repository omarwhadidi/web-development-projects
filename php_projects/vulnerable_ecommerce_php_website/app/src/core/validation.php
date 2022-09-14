<?php 
namespace Ecommerce\Core\Traits;

trait Validation {

	use dbh;

	Protected function ValidateUsername($Username){

		$result;

		if ( !preg_match('/^[A-Za-z][A-Za-z0-9]{3,31}$/', $Username) ) {

			$result = false;
		}
		else {
			$result = true;
		}

		return $result;

	}

	Protected function ValidateName($Name){

		$result;

		if ( !preg_match("/^[a-zA-Z-' ]*$/",$Name)  ) {

			$result = false;
		}
		else {
			$result = true;
		}

		return $result;

	}
	
	protected function validateEmail($email){
		
		// Remove all illegal characters from email
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);

		// Validate e-mail
		if (!empty(filter_var($email, FILTER_VALIDATE_EMAIL)) ) {
		  return 1;
		} else {
		  return 0;
		}

	}

	protected function PasswordPolicy($Password){

		$result;
		$uppercase = preg_match('@[A-Z]@', $Password);
		$lowercase = preg_match('@[a-z]@', $Password);
		$number    = preg_match('@[0-9]@', $Password);

		if(!$uppercase || !$lowercase || !$number || strlen($Password) < 8) {
		  $result = false;
		}
		else {

			$result = true;
		}

		return $result;
		
	}

	protected function MatchPassword($Password,$ConfirmPassword){


		$result;

		if ( $Password !== $ConfirmPassword ) {

			$result = False;
		}
		else {
			$result = True;
		}

		return $result;
		
	}

	
	// Username & Email Database Check
	protected function CheckUserDB($username){

   		$stmt = $this->connect()->prepare("SELECT * FROM users WHERE username = ? ;");
   		
   		if ($stmt->execute(array($username))){

   			$QueryResult;
   			if ($stmt->rowcount() > 0){

   				$QueryResult = True;
	   		}
	   		else {
	   			$QueryResult = False;
	   		}

	   		return $QueryResult;
   		}
   		else {
   			die('error in the sql statement');
   		}
			
    }

    Protected function CheckEmailDB($email){

   		$stmt = $this->connect()->prepare("SELECT * FROM users WHERE  email =? ;");
   		
   		if ($stmt->execute(array($email))){

   			$QueryResult;
   			if ($stmt->rowcount() > 0){

   				$QueryResult = true;
	   		}
	   		else {
	   			$QueryResult = False;
	   		}

	   		return $QueryResult;
   		}
   		else {
   			die('error in the sql statement');
   		}
			
    }


}

?>