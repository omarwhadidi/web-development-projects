<?php
namespace Ecommerce\Core\Traits;

trait Session {


	// Session Methods
	
	Public function ValidateUserSession(){

		if (!isset($_SESSION['loggedin'])){

			//header("HTTP/1.1 401 Unauthorized");
			$_SESSION['redirect_after_login'] = $_SERVER['PHP_SELF'];
		    //header('Location: register.php'); 

		    
		    header('Location: register.php?redirect='.$_SERVER['PHP_SELF']); // Open Redirect 

		    exit();
		}

	}

	Public function ValidateAdminSession(){

		if (!isset($_SESSION['loggedin']) || !isset($_SESSION['isadmin']) ){

			//header("HTTP/1.1 401 Unauthorized");
		    header('Location: ../index.php');
		    // exit(); Prevent Execution After Redirection 
		}

	}

	Public function LimitSessionDuration(){

		$time = $_SERVER['REQUEST_TIME'];
		$timeout_duration = 900;  // for a 15 minute timeout, specified in seconds


		// Log the User Out If he is inactive For % mins

		/*
		* Here we look for the user's LAST_ACTIVITY timestamp. If it's set and indicates our $timeout_duration has passed,
		* remove previous $_SESSION data and start a new one.
		*/
		if (isset($_SESSION['LAST_ACTIVITY']) &&  ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
		    
		    session_unset();
		    session_destroy();
		    header('Location: index.php');  
		    exit();
		    
		}

		// Finally, update LAST_ACTIVITY so that our timeout  is based on it and not the user's login time.

		$_SESSION['LAST_ACTIVITY'] = $_SERVER['REQUEST_TIME'];
		
	}

	Public function ValidateCSRFTokenSession(){

		if (!isset($_SESSION['csrf_token'])) {
		            
		    $_SESSION['csrf_token'] = Generate_Token();

		}

	}

	Public function ValidateLogoutTokenSession(){

		if (!isset($_SESSION['logout_token'])) {
		            
		    $_SESSION['logout_token'] = bin2hex(random_bytes(32)); 

		}

	}


	// cookie Methods

	Protected function hashCookie($Username,$ClientIp) {

	   $storedNonce = 1234;
	   return $UserHash = hash_hmac('sha256', $Username . $ClientIp, $storedNonce);

	}

	Protected function AssignCookie($Username,$ClientIp){

		$time = time() + 3600 * 24 * 30; //hour

		
	    $HashedValue = $this->hashCookie($Username,$ClientIp);
	    //setcookie('usersession', $HashedValue , $time , '/' , null , null , True);             // http only to help mitigate against xss
	    
	    
	    setcookie('usersession', $HashedValue , $time , '/');    



	    $email = $this->GetEmailByUsername($Username);
	    $Result = $this->InsertToken($email,$HashedValue);

	    if ($Result){

	    	return True;
	    }

	}

	Public function CheckCookie() {

		if(isset($_COOKIE['usersession']) && !empty($_COOKIE['usersession']) ) { 
			
			$cookie = $_COOKIE['usersession'];
			$CookieExists = $this->CheckTokenDB($cookie);
			if ($CookieExists == True){

			    $result = hash_equals( $_COOKIE['usersession'], $cookie);
			    if($result == True) {

			    	$email = $this->GetEmailByToken($cookie);
			    	$username = $this->GetUsername($email);

			    	$_SESSION['loggedin'] = True;
			    	$_SESSION['username'] = $username;

			    	return True;
			    }
			    else {

			    	return False;
			    }
			    
			}
			else {

				return False;
			}

		}
		
	}



}














?>