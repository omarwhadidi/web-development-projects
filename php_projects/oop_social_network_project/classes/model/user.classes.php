<?php

 
// include '../includes/core/config.php';


class User extends Dbh {

   




   public function GetUsername($user){

         $stmt = $this->connect()->prepare("SELECT * FROM users WHERE (username LIKE ? || firstname = ? || lastname = ?) ;");
         
         if ($stmt->execute(array('%'.$user.'%',$user,$user))){

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


   // Posts Methods

   protected function InsertPost($user,$post){

      $stmt = $this->connect()->prepare("INSERT INTO posts (username , post) VALUES (?, ?);");

      
      if ($stmt->execute(array($user,$post))){

         return true;
      }
      else {
         return false;
      }

   }

   
   public function GetUserPosts($user){


      $stmt = $this->connect()->prepare("SELECT * FROM posts WHERE  username = ?  ORDER BY postdate DESC ;");
      
      if ($stmt->execute(array($user))){

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

   public function DeletePost($user,$pid){

         $stmt = $this->connect()->prepare("DELETE FROM Posts WHERE username = ? and pid = ?;");
         
         if ($stmt->execute(array($user,$pid))){
            return true;
         }
         else {
            return false;
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


}

?>