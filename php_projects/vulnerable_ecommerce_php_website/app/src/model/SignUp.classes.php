<?php
namespace Ecommerce\Model\Auth;

use Ecommerce\Core\Traits\Dbh; 
use Ecommerce\Core\Traits\Token; 

class SignUp {

	use Dbh,Token;

   // Inserting New User Methods

   Protected function InsertUser($name,$username,$email,$password,$client_ip){

         $UserAddedTime = date("F j, Y"); //date("Y-m-d H:i:s");

   		$stmt = $this->connect()->prepare("INSERT INTO users (name, username , email , password , added_date , client_ip) VALUES (?, ?, ? , ?, ?, ?);");

   		$hashedpwd = password_hash(hash('sha512', $password), PASSWORD_DEFAULT);

   		
   		
   		if ($stmt->execute(array($name, $username,$email, $hashedpwd , $UserAddedTime , $client_ip))){

   			return true;
   		}
   		else {
   			return false;
   		}

   } 

   Protected function InsertGroups($email,$groupid,$group_name){

		$stmt = $this->connect()->prepare("INSERT INTO `groups` (email , group_id ,group_name) VALUES (?, ?, ? );");

		
		if ($stmt->execute(array($email,$groupid,$group_name))){

			return true;
		}
		else {
			return false;
		}

   }
 
   
   // Account Activation Methods

   Protected function UpdateAccountStatus($email){

      $stmt = $this->connect()->prepare("UPDATE users SET Account_status = 1 WHERE email = ? ;");
      
      if ($stmt->execute(array($email))){

         return true;
      }
      else {
         return false;
      }
   
   }

}


?>