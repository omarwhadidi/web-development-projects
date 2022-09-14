<?php
namespace Ecommerce\Model\Admin;

use Ecommerce\Core\Traits\Dbh; 

class Admin {

	use Dbh;

  // Users Methods

	Public function GetAllUsers(){

        $stmt = $this->connect()->prepare("SELECT * FROM users;");
                
        if ($stmt->execute(array())){

            $QueryResult;
            
            $row = $stmt->fetchAll();
               
            $QueryResult = $row;

            return $QueryResult;
        }
        else {
            die('error in the sql statement');
        }

  }

  Public function GetEmailByUsername($username) {

      $stmt = $this->connect()->prepare("SELECT email FROM users WHERE username = ?;");
                  
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

  public function GetUserPermissions($email){

         $stmt = $this->connect()->prepare("SELECT * FROM `groups` WHERE email = ?; ");
         
         if ($stmt->execute(array($email))){

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

         $stmt = $this->connect()->prepare("UPDATE users SET Account_status = 1 WHERE username = ? ;");
         
         if ($stmt->execute(array($username))){

            return true;
         }
         else {
            return false;
         }
   
  }

  public function DeactivateAccount($username){

         $stmt = $this->connect()->prepare("UPDATE users SET Account_status = 0 WHERE username = ? ;");
         
         if ($stmt->execute(array($username))){

            return true;
         }
         else {
            return false;
         }
   
  }

  public function UpgradeAccount($email){

         $stmt = $this->connect()->prepare("UPDATE `groups` SET group_id = 1 ,  group_name = 'Moderator' WHERE email = ? ;");
         
         if ($stmt->execute(array($email))){

            return true;
         }
         else {
            return false;
         }

  }

  public function DowngradeAccount($email){

         $stmt = $this->connect()->prepare("UPDATE `groups` SET group_id = 0 ,  group_name = 'User' WHERE email = ? ;");
         
         if ($stmt->execute(array($email))){

            return true;
         }
         else {
            return false;
         }
   
  }

  // Users Feedback Methods (Contact Us)

  Public function GetUsersFeedbacks(){

        $stmt = $this->connect()->prepare("SELECT * FROM contact_us ;");
                
        if ($stmt->execute(array())){

            $QueryResult;
            
            $row = $stmt->fetchAll();
               
            $QueryResult = $row;

            return $QueryResult;
        }
        else {
            die('error in the sql statement');
        }

  }

  
  // Order Methods

  Public function GetAllOrders(){

        $stmt = $this->connect()->prepare("SELECT * FROM orders ;");
                
        if ($stmt->execute(array())){

            $QueryResult;
            
            $row = $stmt->fetchAll();
               
            $QueryResult = $row;

            return $QueryResult;
        }
        else {
            die('error in the sql statement');
        }

  }

  // Products Methods

  Public function GetAllProducts(){

        $stmt = $this->connect()->prepare("SELECT * FROM products ;");
                
        if ($stmt->execute(array())){

            $QueryResult;
            
            $row = $stmt->fetchAll();
               
            $QueryResult = $row;

            return $QueryResult;
        }
        else {
            die('error in the sql statement');
        }

  }

  Public function GetProductsByID($id) {

      $stmt = $this->connect()->prepare("SELECT * FROM products WHERE product_id = ?;");
                  
         if ($stmt->execute(array($id))){

            $QueryResult;
            
            $row = $stmt->fetchAll();
            
            $QueryResult = $row[0];

            return $QueryResult;
         }
         else {
            die('error in the sql statement');
         }

  }

  Public function InsertProduct($p_name,$category,$product_details,$qty,$price,$seller_name,$p_image,$p_status){

        $date = date("Y-m-d");
        
        $stmt = $this->connect()->prepare("INSERT INTO products (product_name, category , product_details , quantity , price , product_image , seller_name , added_date , product_status) VALUES (?, ?, ? , ?, ? ,? , ?, ?,?);");
         
         
         if ($stmt->execute(array($p_name,$category,$product_details,$qty,$price,$p_image,$seller_name,$date,$p_status))){

            return true;
         }
         else {
            return false;
         }

  } 


}

?>