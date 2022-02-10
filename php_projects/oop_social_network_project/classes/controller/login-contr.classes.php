<?php


class LoginContr extends Login {
 

	private $username;
	private $password;
	private $remember;



	public function SetParams($username , $password ){

		$this->username = $username;
		$this->password = $password;
		
	}

    // Sign in Check Methods

	private function EmptyCheck(){
		
		$results;
		
		if (empty($this->username) || empty($this->password) ) {

			$results = false;
		}
		else {
			$results = true;
		}
	
		return $results;

	}

	public function SignInCheck(){
		
		$errors;
		
		if ($this->EmptyCheck() == false)  {

			$errors = 'Fields are required';
			return $errors;
			exit;		

		}
		
		if (!$this->CheckUser($this->username)){

			$errors = 'Wrong Username or Password';
			return $errors;
			exit;
			
		}

		if ($this->CheckAccountLockout($this->username)){

			$errors = 'Account Locked wait For 15 mins For your next Login';
			return $errors;
			exit;
			
		}

		if (!$this->CheckPass($this->username,$this->password)){

			$errors = 'Wrong Username or Password';
			$time = time();

			$this->InsertFailedLogin($this->username,$time);

			// Log Failed Attempt
			$action="[".date("l jS \of F Y h:i:s A")."] - [ From IP: ".$_SERVER['REMOTE_ADDR']." ] - [ Login Failed Attempt From user ".$this->username." ] .";
			$filename="log.txt";   # The log file

			logmessage($filename,$action);


			return $errors;
			exit;
			
		}
		if (!$this->CheckActivation($this->username)){

			$errors = 'Please Activate Your account First';
			return $errors;
			exit;
			
		}
		
		if (empty($errors)){

			return false;
		}
		
	}
		
	public function SignInUser($username){

		
		$this->ResetFailedLogin($username);

		if ($this->CheckPriv($username) == True){

			session_start();

			$_SESSION['loggedin'] = True;
			$_SESSION['isadmin'] = True;
			$_SESSION['username'] = $username;
			header('Location: admin/admin.php');
			exit;
		}
		else {

			session_start();

			$_SESSION['loggedin'] = True;
			$_SESSION['username'] = $username;
			header('Location: home.php');
			exit;

		}


	}


	// cookie Methods

	private function encryptCookie($value) {

	   $key = hex2bin(openssl_random_pseudo_bytes(4));

	   $cipher = "aes-256-cbc";
	   $ivlen = openssl_cipher_iv_length($cipher);
	   $iv = openssl_random_pseudo_bytes($ivlen);

	   $ciphertext = openssl_encrypt($value, $cipher, $key, 0, $iv);

	   return( base64_encode($ciphertext . '::' . $iv. '::' .$key) );

	}

	private function decryptCookie($ciphertext) {

	   $cipher = "aes-256-cbc";

	   list($encrypted_data, $iv,$key) = explode('::', base64_decode($ciphertext));
	   return openssl_decrypt($encrypted_data, $cipher, $key, 0, $iv);

	}

	public function CheckUserCookie(){

		if(isset($_COOKIE['loggedin']) && !empty($_COOKIE['loggedin']) ) { 
			
			$user = $this->decryptCookie($_COOKIE['loggedin']);

			if ($this->CheckUser($user)){

				$this->SignInUser($user);
			}
	
		} 

	}

	public function SetCookie(){

		$hour = time() + 3600 * 24 * 30;
	        setcookie('loggedin', $this->encryptCookie($this->username) , $hour , '/' , null , null , True);             // http only to help mitigate against xss

	}

}

?>