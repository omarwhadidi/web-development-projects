<?php


// include '../includes/core/config.php';


class SignUp extends Dbh {

   // Inserting New User Methods

   protected function InsertUser($firstname, $lastname, $username,$email, $password, $gender , $regstatus ,$client_ip){

   		$stmt = $this->connect()->prepare("INSERT INTO users (firstname, lastname, username , email , password , gender , regstatus , client_ip) VALUES (?, ?, ? , ?, ?, ? ,?, ?);");

   		$hashedpwd = password_hash(hash('sha512', $password), PASSWORD_DEFAULT);

   		
   		
   		if ($stmt->execute(array($firstname, $lastname, $username,$email, $hashedpwd, $gender , $regstatus ,$client_ip))){

   			return true;
   		}
   		else {
   			return false;
   		}

   	}

   protected function InsertGroups($username,$groupid,$privileges){

		$stmt = $this->connect()->prepare("INSERT INTO groups (username , group_id , permissions) VALUES (?, ?, ? );");

		
		if ($stmt->execute(array( $username,$groupid,$privileges))){

			return true;
		}
		else {
			return false;
		}

   }

   
   // Username & Password Validation Methods

   protected function CheckUser($username){

   		$stmt = $this->connect()->prepare("SELECT * FROM users WHERE username = ? ;");
   		
   		if ($stmt->execute(array($username))){

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


   Protected function CheckEmail($email){

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


   // Account Activation Methods

   protected function InsertToken($email,$token){

      $stmt = $this->connect()->prepare("INSERT INTO password_reset (email , token) VALUES (?, ?);");

      
      if ($stmt->execute(array($email,$token))){

         return true;
      }
      else {
         return false;
      }

   }

   public function ActivateAccount($token){

      $email = $this->CheckToken($token);
      
      if ($email){
      
         $this->UpdateAccount($email);
         $this->DeleteToken($email);

         $result =true;
         
      }
      else {

         $result =false ;
      }

      return $result;

   }

   private function CheckToken($token){

         $stmt = $this->connect()->prepare("SELECT * FROM password_reset WHERE token = ? ;");
         
         if ($stmt->execute(array($token))){

            $QueryResult;
            
            if ($stmt->rowcount() == 1){

               $row = $stmt->fetchAll();
      
               $QueryResult = $row[0]['email'];
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

   private function UpdateAccount($email){

         $stmt = $this->connect()->prepare("UPDATE users SET regstatus = 1 WHERE email = ? ;");
         
         if ($stmt->execute(array($email))){

            return true;
         }
         else {
            return false;
         }
   

   }

   private function DeleteToken($email){

         $stmt = $this->connect()->prepare("Delete FROM password_reset WHERE email = ? ;");
         
         if ($stmt->execute(array($email))){
            return true;
         }
         else {
            return false;
         }
   

   }


}
?>