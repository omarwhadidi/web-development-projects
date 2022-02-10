<?php


// include '../includes/core/config.php';


class Update extends Dbh {

   // Updating Users Data Methods

   protected function UpdateFirstName($firstname,$username){

         $stmt = $this->connect()->prepare("UPDATE users SET firstname = ? WHERE username = ? ;");
         
         if ($stmt->execute(array($firstname,$username))){

            return true;
         }
         else {
            return false;
         }
   

   }

   protected function UpdateLastName($lastname,$username){

         $stmt = $this->connect()->prepare("UPDATE users SET lastname = ? WHERE username = ? ;");
         
         if ($stmt->execute(array($lastname,$username))){

            return true;
         }
         else {
            return false;
         }
   

   }

   protected function UpdateEmail($email,$username){

      $stmt = $this->connect()->prepare("UPDATE users SET email = ? WHERE username = ? ;");
      
      if ($stmt->execute(array($email,$username))){

         return true;
      }
      else {
         return false;
      }
   

   }

   protected function UpdatePassword($newpass,$username){

         $stmt = $this->connect()->prepare("UPDATE users SET password = ? WHERE username = ? ;");

         $hashedpwd = password_hash(hash('sha512', $newpass), PASSWORD_DEFAULT);
         
         if ($stmt->execute(array($hashedpwd,$username))){
            return true;
         }
         else {
            return false;
         }
   

   }

   protected function UpdateUsername($username){

		$stmt = $this->connect()->prepare("UPDATE users SET username = ? WHERE username = ? ;");
      
      if ($stmt->execute(array($username,$username))){

         return true;
      }
      else {
         return false;
      }

   }

   protected function UpdateProfilePic($pic_path,$username){

         $stmt = $this->connect()->prepare("UPDATE users SET profile_pic = ? WHERE username = ? ;");
         
         if ($stmt->execute(array($pic_path,$username))){

            return 1;
         }
         else {
            return false;
         }
   

   }


   // Username & Email Validation Methods

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





}

?>