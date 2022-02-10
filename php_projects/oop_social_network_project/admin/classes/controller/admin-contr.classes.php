<?php


// include '../includes/core/config.php';



class AdminContr extends Admin {


	private $Username;

	

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


		header('Location: ../index.php');
		exit;
		
	}
	
	
	

}





?>