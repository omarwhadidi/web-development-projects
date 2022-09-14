<?php
namespace Ecommerce\Model\Auth;

use Ecommerce\Core\Traits\Dbh; 

class Login {

	use Dbh; 
	

	// User Login Check Methods

   Protected function GetUsername($email) {

      $stmt = $this->connect()->prepare("SELECT * FROM users WHERE email = ? ;");
                  
         if ($stmt->execute(array($email))){

            $QueryResult;
            
            $row = $stmt->fetchAll();
            
            $QueryResult = $row[0]['username'];

            return $QueryResult;
         }
         else {
            die('error in the sql statement');
         }

   }

   Protected function GetEmailByUsername($username) {

      $stmt = $this->connect()->prepare("SELECT * FROM users WHERE username = ? ;");
                  
         if ($stmt->execute(array($username))){

            $QueryResult;
            
            $row = $stmt->fetchAll();
            
            $QueryResult = $row[0]['email'];

            return $QueryResult;
         }
         else {
            die('error in the sql statement');
         }

   }

   Protected function CheckPass($email,$password){

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
         
   }

	Protected function GetAccountStatus($email){

   		$stmt = $this->connect()->prepare("SELECT * FROM users WHERE email = ? ;");
   		
   		
   		if ($stmt->execute(array($email))){

   			$QueryResult;
   			
   			$row = $stmt->fetchAll();
		
			$verify = $row[0]['Account_status'];
   			
   			if ($verify == 0){

   				$QueryResult = False;
	   		}
	   		else {
	   			$QueryResult = True;
	   		}

	   		return $QueryResult;
   		}
   		else {
   			die('error in the sql statement');
   		}
			
    }

	Protected function GetAccountPriv($email) {

		$stmt = $this->connect()->prepare("SELECT * FROM users WHERE email = ? ;");
   		   		
   		if ($stmt->execute(array($email))){

   			$QueryResult;
   			
   			$row = $stmt->fetchAll();
			   
            $QueryResult = $row[0]['group_id'];

	   		return $QueryResult;
   		}
   		else {
   			die('error in the sql statement');
   		}

	}
	
	
   // 2 Factor Auth Methods

   Protected function CheckEnabledMFA($email) {

      $stmt = $this->connect()->prepare("SELECT * FROM users WHERE email = ? ;");
                  
         if ($stmt->execute(array($email))){

            $QueryResult;
            
            $row = $stmt->fetchAll();
            
            $QueryResult = $row[0]['mfa'];

            return $QueryResult;
         }
         else {
            die('error in the sql statement');
         }

   }

   Protected function CheckMFACodeDB($mfacode){

       $stmt = $this->connect()->prepare("SELECT * FROM mfa WHERE code = ? ;");
       
       if ($stmt->execute(array($mfacode))){

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

   Protected function CheckMFACodeExpiry($mfacode){

      $curDate = $_SERVER['REQUEST_TIME'];
      $timeout_duration = 60;

      $stmt = $this->connect()->prepare("SELECT * FROM mfa WHERE code = ? ;");
                  
      if ($stmt->execute(array($mfacode))){


         $row = $stmt->fetchAll();
         $TokenExpDate = $row[0]['duration'];

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

   Protected function InsertMFACode($email,$mfacode){

      $time = $_SERVER['REQUEST_TIME'];

      $stmt = $this->connect()->prepare("INSERT INTO mfa (email ,code, Duration) VALUES (?, ? ,?);");

      
      if ($stmt->execute(array($email,$mfacode,$time))){

         return true;
      }
      else {
         return false;
      }

   }
 
   Protected function DeleteMFACode($email){

      $stmt = $this->connect()->prepare("DELETE FROM mfa WHERE email = ? ;");
      
      if ($stmt->execute(array($email))){
         return true;
      }
      else {
         return false;
      }

   }  

   Protected function GetMFACodeByEmail($email){

      $stmt = $this->connect()->prepare("SELECT * FROM mfa WHERE email = ? ;");
                  
      if ($stmt->execute(array($email))){


         $row = $stmt->fetchAll();
         $token = $row[0]['code'];


         return $token;
      }
      else {
         die('error in the sql statement');
      }

   } 


   // Account Lockout Methods

   Protected function CheckAccountLockout($email,$Client_ip,$useragent){

         $stmt = $this->connect()->prepare("SELECT * FROM users WHERE email = ? ;");
         
         if ($stmt->execute(array($email))){

            $account_locked     = False;
            $total_failed_login = 6;
            $lockout_time       = 900;
            
            $row = $stmt->fetchAll();


            if ($row[0]['failed_login'] >= $total_failed_login){

               $last_login = $row[0]['last_login'] ;
               $timeout    = $last_login ;
               $timenow    = time();

               //echo $timenow - $timeout .'<br>';

               if( $timenow - $timeout < $lockout_time ) {

                  $account_locked = True;

               }

            }
            

            return $account_locked;
         }
         else {
            die('error in the sql statement');
         }
           
   }
   
   Protected function InsertFailedLogin($email,$time){

      $stmt = $this->connect()->prepare("UPDATE users SET failed_login = (failed_login + 1) , last_login = ? WHERE email = ? ;");

      
      if ($stmt->execute(array($time,$email))){

         return true;
      }
      else {
         return false;
      }

   }

   Protected function ResetFailedLogin($email){

      $stmt = $this->connect()->prepare("UPDATE users SET failed_login = 0  WHERE email = ? ;");

      
      if ($stmt->execute(array($email))){

         return true;
      }
      else {
         return false;
      }

   }
   

}



?>