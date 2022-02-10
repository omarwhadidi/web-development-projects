<?php


// include '../includes/core/config.php';


class Admin extends Dbh {

   
   public function GetUsername($user){

         $stmt = $this->connect()->prepare("SELECT * FROM users WHERE (username = ? || firstname = ? || lastname = ?) ;");
         
         if ($stmt->execute(array($user,$user,$user))){

            $QueryResult;
            
            if ($stmt->rowcount() > 0){

               $row = $stmt->fetchAll();
      
               $QueryResult = $row;
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
   
   public function GetUserInfo($user){

         $stmt = $this->connect()->prepare("SELECT * FROM users WHERE username = ? ;");
         
         if ($stmt->execute(array($user))){

            $QueryResult;
            
            if ($stmt->rowcount() == 1){

               $row = $stmt->fetchAll();
      
               $QueryResult = $row[0];
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

   // POST Methods

   protected function InsertPost($user,$post){

      $stmt = $this->connect()->prepare("INSERT INTO posts (username , post) VALUES (?, ?);");

      
      if ($stmt->execute(array($user,$post))){

         return true;
      }
      else {
         return false;
      }

   }

   
   public function GetUserPosts($username){

         $stmt = $this->connect()->prepare("SELECT * FROM posts WHERE username = ? ORDER BY postdate DESC ;");
         
         if ($stmt->execute(array($username))){

            $rows = $stmt->fetchAll();
            return $rows;
               

         }
         else {

            die('error in the sql statement');
         }
      

   }

   public function GetAllPosts(){

         $stmt = $this->connect()->prepare("SELECT * FROM posts ORDER BY postdate DESC ;");
         
         if ($stmt->execute()){

            $rows = $stmt->fetchAll();
            return $rows;
               

         }
         else {

            die('error in the sql statement');
         }
      

   }


   public function LikePost($user,$pid){

      $stmt = $this->connect()->prepare("UPDATE posts SET likes = likes + 1 WHERE username = ? and pid = ? ;");
      
      if ($stmt->execute(array($user,$pid))){
         return true;
      }
      else {
         return false;
      }

      }


   // Admin Methods

   public function DeletePost($user,$pid){

         $stmt = $this->connect()->prepare("DELETE FROM Posts WHERE username = ? and pid = ?;");
         
         if ($stmt->execute(array($user,$pid))){
            return true;
         }
         else {
            return false;
         }
   

   }  


   public function GetAllUsers(){

      $stmt = $this->connect()->prepare("SELECT * FROM users  ;");
      
      if ($stmt->execute()){

         $rows = $stmt->fetchAll();
         return $rows;
            

      }
      else {

         die('error in the sql statement');
      }
   

   }

   public function GetUserPermissions($username){

         $stmt = $this->connect()->prepare("SELECT * FROM groups WHERE username = ? ");
         
         if ($stmt->execute(array($username))){

            $QueryResult;
            
            if ($stmt->rowcount() == 1){

               $row = $stmt->fetchAll();
      
               $QueryResult = $row[0];
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

   public function ActivateAccount($username){

         $stmt = $this->connect()->prepare("UPDATE users SET Regstatus = 1 WHERE username = ? ;");
         
         if ($stmt->execute(array($username))){

            return true;
         }
         else {
            return false;
         }
   

   }

   public function DeactivateAccount($username){

         $stmt = $this->connect()->prepare("UPDATE users SET Regstatus = 0 WHERE username = ? ;");
         
         if ($stmt->execute(array($username))){

            return true;
         }
         else {
            return false;
         }
   

   }

   public function UpgradeAccount($username){

         $stmt = $this->connect()->prepare("UPDATE groups SET group_id = 1 ,  permissions = 'Moderator' WHERE username = ? ;");
         
         if ($stmt->execute(array($username))){

            return true;
         }
         else {
            return false;
         }
   

   }

   public function DowngradeAccount($username){

         $stmt = $this->connect()->prepare("UPDATE groups SET group_id = 0 ,  permissions = 'User' WHERE username = ? ;");
         
         if ($stmt->execute(array($username))){

            return true;
         }
         else {
            return false;
         }
   

   }




}

?>

