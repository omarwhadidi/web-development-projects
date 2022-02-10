<?php


Class Session {


	public function ValidateAdminSession(){

		if (!isset($_SESSION['loggedin']) || !isset($_SESSION['isadmin']) ){

		    header('Location: ../index.php');
		    exit;
		}

	}

	public function ValidateLogoutTokenSession(){

		if (!isset($_SESSION['logout_token'])) {
		            
		    $_SESSION['logout_token'] = bin2hex(random_bytes(32));

		}

	}

	public function LimitSessionDuration(){

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
		    header('Location: ../index.php');  
		    exit();
		    
		}

		// Finally, update LAST_ACTIVITY so that our timeout  is based on it and not the user's login time.

		$_SESSION['LAST_ACTIVITY'] = $_SERVER['REQUEST_TIME'];

	}



}














?>