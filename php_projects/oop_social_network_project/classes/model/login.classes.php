<?php

class Login extends Dbh{

 
   // User Validation Methods

	protected function CheckActivation($username){

   		$stmt = $this->connect()->prepare("SELECT * FROM users WHERE username = ? ;");
   		
   		
   		if ($stmt->execute(array($username))){

   			$QueryResult;
   			
   			$row = $stmt->fetchAll();
		
			$verify = $row[0]['regstatus'];
   			
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

	protected function CheckPriv($username) {

		$stmt = $this->connect()->prepare("SELECT * FROM groups WHERE username = ? ;");
   		   		
   		if ($stmt->execute(array($username))){

   			$QueryResult;
   			
   			$row = $stmt->fetchAll();
			   
            $permissions = $row[0]['group_id'];
   			
   			if ($permissions == 0){

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

	protected function CheckPass($username,$password){

   		$stmt = $this->connect()->prepare("SELECT * FROM users WHERE username = ? ;");
   		
   		
   		if ($stmt->execute(array($username))){

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

   // Account Lockout Methods

   protected function CheckAccountLockout($username){

         $stmt = $this->connect()->prepare("SELECT * FROM users WHERE username = ? ;");
         
         if ($stmt->execute(array($username))){

            $account_locked=False;
            $total_failed_login = 3;
            $lockout_time       = 900;
            
            $row = $stmt->fetchAll();


            if ($row[0]['failed_login'] >= $total_failed_login){

               $last_login = $row[0]['last_login'] ;
               $timeout    = $last_login ;
               $timenow    = time();

               //echo $timenow - $timeout .'<br>';

               if( $timenow - $timeout < $lockout_time ) {

                  $account_locked = True;

                     // Log Lockout Account
                     $action="[".date("l jS \of F Y h:i:s A")."] - [ From IP: ".$_SERVER['REMOTE_ADDR']." ] - [ Attempt to access Locked Account For User ".$row[0]['username']." ] .";
                     $filename="log.txt";   # The log file
                     logmessage($filename,$action);
               }

            }
            

            return $account_locked;
         }
         else {
            die('error in the sql statement');
         }
           
   }
   
   protected function InsertFailedLogin($username,$time){

      $stmt = $this->connect()->prepare("UPDATE users SET failed_login = (failed_login+1), last_login =? WHERE username = ? ;");

      
      if ($stmt->execute(array($time,$username))){

         return true;
      }
      else {
         return false;
      }

   }

   protected function ResetFailedLogin($username){

      $stmt = $this->connect()->prepare("UPDATE users SET failed_login = 0  WHERE username = ? ;");

      
      if ($stmt->execute(array($username))){

         return true;
      }
      else {
         return false;
      }

   }
 
}

?>