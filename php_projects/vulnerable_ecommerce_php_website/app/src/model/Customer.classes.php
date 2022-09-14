<?php
namespace Ecommerce\Model\User; 

use Ecommerce\Core\Traits\Dbh; 

class Customer {

	use Dbh;


	Protected function GetUserInfo($username){

        $stmt = $this->connect()->prepare("SELECT * FROM users WHERE username = ? ;");
                
        if ($stmt->execute(array($username))){

            $QueryResult;
            
            $row = $stmt->fetchAll();
               
            $QueryResult = $row[0];

            return $QueryResult;
        }
        else {
            die('error in the sql statement');
        }

  }

  // Contact Us Methods

  Protected function InsertFeedback($name,$email,$subject,$message){

     $stmt = $this->connect()->prepare("INSERT INTO contact_us (name, email , subject , message) VALUES (?, ?, ? ,?);");
     
     
     if ($stmt->execute(array($name,$email,$subject,$message))){

        return true;
     }
     else {
        return false;
     }

  } 


  // User Reviews Methods

  Protected function InsertUserReview($review,$username,$productid){

     $ReviewTime = date("F j, Y"); //date("Y-m-d H:i:s");

     $stmt = $this->connect()->prepare("INSERT INTO reviews (review ,username, product_id , review_date) VALUES (?, ?, ? , ?);");
     
     
     if ($stmt->execute(array($review, $username,$productid, $ReviewTime))){

        return true;
     }
     else {
        return false;
     }

  } 

  Protected function GetReviewsByID($id) {

      $stmt = $this->connect()->prepare("SELECT * FROM reviews WHERE product_id = ?;");
                  
         if ($stmt->execute(array($id))){

            $QueryResult;
            
            $row = $stmt->fetchAll();
            
            $QueryResult = $row;

            return $QueryResult;
         }
         else {
            die('error in the sql statement');
         }

  }


  // Orders Methods
   
  Protected function InsertOrder($name,$username,$email,$phone,$address,$payment_mode,$products,$paid_amount){

    $OrderAddedTime = date("F j, Y"); //date("Y-m-d H:i:s");
    
    $stmt = $this->connect()->prepare("INSERT INTO orders (name, username , email , phone , address , payment_mode , products , paid_amount,order_date) VALUES (?, ?, ? , ?, ? ,? , ?, ?,?);");
     
     
    if ($stmt->execute(array($name, $username,$email, $phone , $address , $payment_mode , $products , $paid_amount,$OrderAddedTime))){

        return true;
    }
    else {
        return false;
    }

  } 

  Protected function CheckOrderDB($id) {

      $stmt = $this->connect()->prepare("SELECT * FROM orders WHERE order_id = ? ;");
                  
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

  Protected function GetUserOrders($username) {

      $stmt = $this->connect()->prepare("SELECT * FROM orders WHERE username = ?;");
                  
         if ($stmt->execute(array($username))){

            $QueryResult;
            
            $row = $stmt->fetchAll();
            
            $QueryResult = $row;

            return $QueryResult;
         }
         else {
            die('error in the sql statement');
         }

  }

  Protected function GetOrderById($id) {

      $stmt = $this->connect()->prepare("SELECT * FROM orders WHERE order_id = ?;");
                  
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


  // Products Methods

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

  Protected function DeductProductQantity($pid,$qty){

      $stmt = $this->connect()->prepare("UPDATE products SET quantity = quantity - ? WHERE product_id = ? ;");
       
      if ($stmt->execute(array($qty,$pid))){

          return true;
      }
      else {
          return false;
      }
 
  }


  // Coupon Methods

  Protected function CheckCouponDB($coupon){

      $stmt = $this->connect()->prepare("SELECT * FROM coupon WHERE coupon_code = ? ;");
     
      if ($stmt->execute(array($coupon))){

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

  Protected function GetCoupon($coupon) {

      $stmt = $this->connect()->prepare("SELECT * FROM coupon WHERE coupon_code = ?;");
                  
         if ($stmt->execute(array($coupon))){

            $QueryResult;
            
            $row = $stmt->fetchAll();
            
            $QueryResult = $row[0];

            return $QueryResult;
         }
         else {
            die('error in the sql statement');
         }

  }

  Private function GetUserCouponsUsed($coupon,$user){

      $stmt = $this->connect()->prepare("SELECT * FROM users WHERE username = ? ;");
               
      if ($stmt->execute(array($user))){

         $QueryResult;
         
         $row = $stmt->fetchAll();
         
         $QueryResult = $row[0]['couponused'];

         return json_decode($QueryResult,True);
      }
      else {
         die('error in the sql statement');
      }

  }

  Protected function CheckUserUsedCoupons($coupon,$user) {

      $UserCouponUsed = $this->GetUserCouponsUsed($coupon,$user);

      if($UserCouponUsed !== NULL){

         if (in_array($coupon, $UserCouponUsed)){

            return True;
         } 
         else {
            return False;
         }
      }
      else {

         return False;
      }
      
  }

  Protected function AddToUserUsedCoupons($coupon,$user) {

      $UserCouponUsed = $this->GetUserCouponsUsed($coupon,$user);
      if ($UserCouponUsed == NULL){
        $UserCouponUsed = array();
      }
      array_push($UserCouponUsed, $coupon);
      $JSONCoupons = json_encode($UserCouponUsed);

      $stmt = $this->connect()->prepare("UPDATE users SET couponused = ? WHERE username = ?;");
     
     
      if ($stmt->execute(array($JSONCoupons,$user))){

        return true;
      }
      else {
        return false;
      }

  }

}

?>