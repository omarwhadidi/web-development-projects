<?php
namespace Ecommerce\Model\User; 

use Ecommerce\Core\Traits\Dbh; 

class Update {

	use dbh;

	Protected function UpdateFullName($name,$username){

        $stmt = $this->connect()->prepare("UPDATE users SET name = ? WHERE username = ? ;");
         
        if ($stmt->execute(array($name,$username))){

            return true;
        }
        else {
            return false;
        }
   
    }

    Protected function UpdateUsername($username,$usersession){

    	$stmt = $this->connect()->prepare("UPDATE users SET username = ? WHERE username = ? ;");
      
    	if ($stmt->execute(array($username,$usersession))){

        	return true;
    	
    	}
        else {
        	return false;
    	}

	}

	Protected function UpdateEmail($email,$username){

    	$stmt = $this->connect()->prepare("UPDATE users SET email = ? WHERE username = ? ;");
      
    	if ($stmt->execute(array($email,$username))){

        	return true;
    	
    	}
        else {
        	return false;
    	}

	}

    Protected function UpdateGender($gender,$username){

    	$stmt = $this->connect()->prepare("UPDATE users SET gender = ? WHERE username = ? ;");
      
    	if ($stmt->execute(array($gender,$username))){

        	return true;
    	
    	}
        else {
        	return false;
    	}
    	
	}

    Protected function UpdatePassword($newpass,$username){

         $stmt = $this->connect()->prepare("UPDATE users SET password = ? WHERE username = ? ;");

         $hashedpwd = password_hash(hash('sha512', $newpass), PASSWORD_DEFAULT);
         
         if ($stmt->execute(array($hashedpwd,$username))){
            return true;
         }
         else {
            return false;
         }
   
    }

	Protected function UpdateProfilePic($pic_path,$username){

         $stmt = $this->connect()->prepare("UPDATE users SET userpic = ? WHERE username = ? ;");
         
         if ($stmt->execute(array($pic_path,$username))){

            return 1;
         }
         else {
            return false;
         }
   
    }

    Protected function Update2FA($mfa,$username){

        $stmt = $this->connect()->prepare("UPDATE users SET mfa = ? WHERE username = ? ;");
      
        if ($stmt->execute(array($mfa,$username))){

            return true;
        
        }
        else {
            return false;
        }
        
    }



}

?>