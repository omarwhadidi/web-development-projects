<?php
namespace Ecommerce\Core\Traits;

trait Token {
	
	use Dbh;

	Protected function CheckTokenDB($token){

       $stmt = $this->connect()->prepare("SELECT * FROM tokens WHERE token = ? ;");
       
       if ($stmt->execute(array($token))){

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

    Protected function CheckTokenExpiry($token){

		$curDate = $_SERVER['REQUEST_TIME'];
		$timeout_duration = 240;

		$stmt = $this->connect()->prepare("SELECT * FROM tokens WHERE token = ? ;");
		            
		if ($stmt->execute(array($token))){


			$row = $stmt->fetchAll();
			$TokenExpDate = $row[0]['Duration'];

			if($curDate - $TokenExpDate <= $timeout_duration ){

				return True;
			}
			else {

				return False;
			}

		}
		else {
			die('error in the sql statement');
		}

	}

	Protected function GetTokenByEmail($email){

		$stmt = $this->connect()->prepare("SELECT * FROM tokens WHERE email = ? ;");
		            
		if ($stmt->execute(array($email))){


			$row = $stmt->fetchAll();
			$token = $row[0]['token'];


			return $token;
		}
		else {
			die('error in the sql statement');
		}

	} 

	Protected function GetEmailByToken($token){

		$stmt = $this->connect()->prepare("SELECT * FROM tokens WHERE token = ? ;");
		            
		if ($stmt->execute(array($token))){


			$row = $stmt->fetchAll();
			$email = $row[0]['email'];


			return $email;
		}
		else {
			die('error in the sql statement');
		}

	} 

	protected function InsertToken($email,$token){

		$time = $_SERVER['REQUEST_TIME'];

		$stmt = $this->connect()->prepare("INSERT INTO tokens (email ,token, Duration) VALUES (?, ? ,?);");

		
		if ($stmt->execute(array($email,$token,$time))){

			return true;
		}
		else {
			return false;
		}

	}
 
	protected function DeleteToken($email){

	   $stmt = $this->connect()->prepare("DELETE FROM tokens WHERE email = ? ;");
	   
	   if ($stmt->execute(array($email))){
	      return true;
	   }
	   else {
	      return false;
	   }

	}
	
}















?>