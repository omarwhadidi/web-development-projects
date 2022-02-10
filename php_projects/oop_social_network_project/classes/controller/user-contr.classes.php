<?php


class UserContr extends User {


	private $Username;


	public function __construct(){
		

		$this->LimitSessionDuration();

	}

	private function LimitSessionDuration(){

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

	public function SetUsername($UN){

		$this->Username = $UN;
	}

	public function SharePost($post){


		if(!empty($post)){

			if($this->InsertPost($this->Username,$post)){

				return True;
			}
			
		}

	}


	public function Logout(){
	
		session_unset();
		session_destroy();

		if(isset($_COOKIE['loggedin'])) {
	      setcookie ("loggedin","",time()- (90 * 365 * 24 * 60 * 60), "/");
	      //setcookie("loggedin", "");
		}


		header('Location: index.php');
		exit;
		
	}
	
	
	

}





?>