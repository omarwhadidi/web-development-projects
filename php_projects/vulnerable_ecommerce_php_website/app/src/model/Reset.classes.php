<?php
namespace Ecommerce\Model\Auth;

use Ecommerce\Core\Traits\Dbh; 

class Reset {

	use dbh;


  Protected function GetOldPassword($email){

  	$stmt = $this->connect()->prepare("SELECT * FROM users WHERE email = ? ;");
  	
  	
  	if ($stmt->execute(array($email))) {

  		$QueryResult;
  		
  		$row = $stmt->fetchAll();
  	    $QueryResult = $row[0]['password'];

   			return $QueryResult;
  	}
  	else {
  		die('error in the sql statement');
  	}

  }

  Protected function UpdatePassword($email,$newpass){

  	$hashedpwd = password_hash(hash('sha512', $newpass), PASSWORD_DEFAULT);

      $stmt = $this->connect()->prepare("UPDATE users SET password = ? WHERE email = ? ;");
       
      if ($stmt->execute(array($hashedpwd,$email))){
          return true;
      }
      else {
          return false;
      }

  }

}







?>