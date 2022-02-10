<?php

class Reset extends Dbh {


   Protected function GetEmail($token){

      $stmt = $this->connect()->prepare("SELECT * FROM password_reset WHERE token = ? ;");
                  
         if ($stmt->execute(array($token))){

            
            $row = $stmt->fetchAll();
         $email = $row[0]['email'];
            

            return $email;
         }
         else {
            die('error in the sql statement');
         }


   } 

	protected function CheckEmail($email){

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


   Private function CheckToken($token){

         $stmt = $this->connect()->prepare("SELECT * FROM password_reset WHERE token = ? ;");
         
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

   protected function InsertToken($email,$token){

   		$stmt = $this->connect()->prepare("INSERT INTO password_reset (email ,token) VALUES (?, ? );");

   		
   		if ($stmt->execute(array($email,$token))){

   			return true;
   		}
   		else {
   			return false;
   		}

		
   }

   
   protected function DeleteToken($email){

         $stmt = $this->connect()->prepare("Delete FROM password_reset WHERE email = ? ;");
         
         if ($stmt->execute(array($email))){
            return true;
         }
         else {
            return false;
         }
   

   }  

	
/*	protected function CheckCurrentPass($email,$password){

		$stmt = $this->connect()->prepare("SELECT * FROM users WHERE email = ? ;");
		
		
		if ($stmt->execute(array($email))){

			$QueryResult;
			
			$row = $stmt->fetchAll();
		$verify = password_verify(hash('sha512', $password), $row[0]['password']);
			
			if ($verify == false){

				$QueryResult = False;
   		}
   		else {
   			$QueryResult = true;
   		}

   		return $QueryResult;
		}
		else {
			die('error in the sql statement');
		}
	
		
    }*/

   public function ValidateUser($token){

      $result = $this->CheckToken($token);

      if ($result){

         $email = $this->GetEmail($token);
         return $email;
      }
      else {

         return false;
      }

   }
   	
	protected function UpdatePassword($email,$newpass){

   		$stmt = $this->connect()->prepare("UPDATE users SET password = ? WHERE email = ? ;");
   		
   		if ($stmt->execute(array($newpass,$email))){
   			return true;
   		}
   		else {
   			return false;
   		}
	

	}




}

?>