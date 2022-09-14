<?php
namespace Ecommerce\Model\Product;  

use Ecommerce\Core\Traits\Dbh; 

class Product {

	use Dbh;

   // Product Methods

   Protected function CheckProductDB($id){

         $stmt = $this->connect()->prepare("SELECT * FROM products WHERE product_id = ? ;");
         
         if ($stmt->execute(array($id))){

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

   Protected function GetProductAvailibity($pid) {

      $stmt = $this->connect()->prepare("SELECT * FROM products WHERE product_id = ? ;");
                  
         if ($stmt->execute(array($pid))){

            $QueryResult;
            
            $row = $stmt->fetchAll();
            
            $QueryResult = $row[0]['quantity'];

            return $QueryResult;
         }
         else {
            die('error in the sql statement');
         }

   }   

	Public function GetProductInfo($pname) {

      $stmt = $this->connect()->prepare("SELECT * FROM products WHERE product_name = ? ;");
                  
         if ($stmt->execute(array($pname))){

            $QueryResult;
            
            $row = $stmt->fetchAll();
            
            $QueryResult = $row[0];

            return $QueryResult;
         }
         else {
            die('error in the sql statement');
         }

   }

	Protected function GetAllProducts() {

      $stmt = $this->connect()->prepare("SELECT * FROM products ORDER BY added_date;");
                  
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

   Protected function GetProductsByName($name) {

      $search = "%$name%";
      $stmt = $this->connect()->query("SELECT * FROM products WHERE product_name LIKE '$search'");
      $row = $stmt->fetchAll();
      return $row;

      //$stmt = $this->connect()->prepare("SELECT * FROM products WHERE product_name LIKE ? ;");
                  
/*       if ($stmt->execute(array($Search))){

            $QueryResult;
            
            $row = $stmt->fetchAll();
            
            $QueryResult = $row;

            return $QueryResult;
         }
         else {
            die('error in the sql statement');
         }*/

   }

	Protected function GetProductsByCategory($category) {

      $stmt = $this->connect()->prepare("SELECT * FROM products WHERE category = ? ORDER BY added_date;");
                  
         if ($stmt->execute(array($category))){

            $QueryResult;
            
            $row = $stmt->fetchAll();
            
            $QueryResult = $row;

            return $QueryResult;
         }
         else {
            die('error in the sql statement');
         }

   }



}

?>