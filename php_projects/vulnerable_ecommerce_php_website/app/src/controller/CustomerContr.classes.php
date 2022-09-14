<?php 
namespace Ecommerce\Controller\User; 

use Ecommerce\Model\User\Customer;
use Ecommerce\Core\Traits\Validation; 


class CustomerContr extends Customer {

	use Validation; 

	Public function GetUserDetails($username){

		return $this->GetUserInfo($username);

	}

	// Contact Us Methods

	Public function SendFeedback($name,$email,$subject,$message){

		if (empty($name) == True || empty($email) == True || empty($subject) == True  || empty($message) == True ){
			
			return 'All Fields are Required';
			exit();
		}

		if ($this->validateEmail($email) == 0){
			return 'Please Enter a valid Email';
			exit();

		} 

		$name = filter_var($name, FILTER_SANITIZE_STRING);
		//$subject = filter_var($subject, FILTER_SANITIZE_STRING);  // BLIND XSS
		$message = filter_var($message, FILTER_SANITIZE_STRING);

		$this->InsertFeedback($name,$email,$subject,$message);
		return True;

	}

	// Product Reviews
	
	Public function HandleUserReview($review, $username,$productid){

		// Removing all the illegal characters from User Input 
		$UserInput = $review;
		// $UserInput = filter_var($review, FILTER_SANITIZE_STRING); Prevent Stored XSS
		if ($this->InsertUserReview($UserInput, $username,$productid)){
			return true;
		}
		else {
			return False;
		}

	}
	
	Public function ReturnReviewsByID($id){

		return $this->GetReviewsByID($id);

	}

	// Cart Methods

	Public function AddToCart($product_id){

		$ProductFound = $this->CheckProductDB($product_id);
		if ($ProductFound == True) {

			$CheckinStock = $this->GetProductAvailibity($product_id);
			if($CheckinStock > 0){


		        // Product exists in database, now we can create/update the session variable for the cart
		         if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
			        if (array_key_exists($product_id, $_SESSION['cart'])) {
			            // Product exists in cart so just update the quanity
			            $_SESSION['cart'][$product_id]['qty'] += 1;
			        } else {
			            // Product is not in cart so add it
			            $_SESSION['cart'][$product_id]['qty'] = 1;
			            $_SESSION['cart'][$product_id]['pid'] = (int) $product_id;
			        }
			    } else {
			        // There are no products in cart, this will add the first product to cart
			        $_SESSION['cart'][$product_id] = array('pid' => (int) $product_id,'qty' => 1);
			    }

				return True;
			}
			else {
				return 'Product Out Of Stock';
			}
		}
		else {
			return 'Product Not Found';
		}

	}

	Public function RemoveFromCart($pid){

		if (isset($_SESSION['cart']) && isset($_SESSION['cart'][$pid]) )
		{
			// Remove the product from the shopping cart
   		 	unset($_SESSION['cart'][$pid]);	
   		 	return True;
		}
		else {
			return False;
		}
		
	}

	Public function EmptyCart(){

		if (isset($_SESSION['cart']) && !empty($_SESSION['cart']) )
		{
			// Empty cart
		    unset($_SESSION['cart']);
   		 	return True;
		}
		else {
			return False;
		}
		
	}


	// Coupon Methods

	Public function GenerateCoupon($l){
		$coupon = "PR".substr(str_shuffle(str_repeat('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',$l-2)),0,$l-2);
 
		return $coupon;

	}
	
	Public function ValidateCoupon($coupon,$user){


		if (empty($coupon) == True){

			return 'Empty Coupon';
			exit();
		}
		if ($this->CheckCouponDB($coupon) == False){

			return 'Coupon Doesnt Exists';
			exit();
		}

		$couponDB = $this->GetCoupon($coupon);

		if($couponDB['status'] != 'Active'){

			return 'Coupon is Inactive Now Try Another Time';
			exit();
		}

		$UserFound = $this->CheckUserDB($user);
		
		if ($UserFound !== False){
			
			$Result = $this->CheckUserUsedCoupons($coupon,$user);

			if ($Result === True ){

				return 'You Already Used This Coupon';
				exit();
			}

		}


		return True;
		
	}

	Public function ApplyCoupon($coupon){

		$CouponDetails = $this->GetCoupon($coupon);
		$discount = $CouponDetails['discount'] /100;
        $_SESSION['discount'] = $discount;
        $_SESSION['used_coupon'] = $coupon;

		return $CouponDetails;

	}




	// Checkout Methods

	Public function Checkout($name,$Username,$email, $phone , $address, $CreditCard , $products , $paid_amount){


		$ValidationResult = $this->ValidateCheckout($name,$Username,$email, $phone , $address, $CreditCard , $products , $paid_amount);
		if ($ValidationResult === True){

			// Make an Order
			$this->InsertOrder($name, $Username,$email, $phone , $address, $CreditCard , $products , $paid_amount);

			// Reduce Product Quantity 
			$Userproducts = json_decode($products,true); 
			foreach ($Userproducts as $Userproduct) {
			 	$this->DeductProductQantity($Userproduct['pid'],$Userproduct['qty']);
			 }
 			
 			// Reset User Cart
		    $this->EmptyCart();

		    // Add Used Coupon 
		    if (isset($_SESSION['discount'])){
			   	$UserFound = $this->CheckUserDB($Username);
				if ($UserFound !== False){

					$this->AddToUserUsedCoupons($_SESSION['used_coupon'],$Username);
				}

			    unset($_SESSION['discount']);
			    unset($_SESSION['used_coupon']);

		    }

		   	return True;
		}
		else {
			return $ValidationResult;
		}

	}

	Private function ValidateCheckout($name,$Username,$email, $phone , $address, $CreditCard , $products , $paid_amount){

		if ($this->EmptyCheckoutFields($name,$email, $phone , $address, $CreditCard , $products , $paid_amount) == False){

			return 'All Fields Are required ';
			exit();
		}

		if($this->ValidateName($name) == False){

			return 'Please Provide a Valid Name';
			exit();
		}

		if($this->validateEmail($email) == False){

			return 'Please Provide a Valid Email';
			exit();
		}

		if (filter_var($phone, FILTER_VALIDATE_INT) == false) {

			return 'Please Provide a Valid Phone number';
			exit();
		} 

		if (filter_var($CreditCard, FILTER_VALIDATE_INT) == false) {

			return 'Please Provide a Valid Credit Card';
			exit();
		} 

		$num_length = strlen((string)$CreditCard);
		if($num_length !== 16) {

		   	return 'Please Provide a Valid Credit Card';
			exit();
		}

		return True;
		
	}

	Private function EmptyCheckoutFields($name,$email, $phone , $address, $payment_mode , $products , $paid_amount){

		$results;

		if (empty($name) == True || empty($email) == True || empty($phone) == True  || empty($address) == True   || empty($payment_mode) == True || empty($products) == True || empty($paid_amount) == True  ){
			
			$results = False;
		}
		else {
			$results = True;
		}
	
		return $results;

	}

	// Orders Methods

	Public function CheckUserOrder($OrderId,$UserSession){

		if ($this->CheckOrderDB($OrderId) !== True){

			return False;
			exit();
		}

		$OrderDetails = $this->GetOrderById($OrderId) ;
		$UserRequested = $OrderDetails['username'];

		if ($UserRequested !== $UserSession){
			
		   return False;
		   exit($_SERVER['SERVER_PROTOCOL'] . ' Unauthorized Access');

		}

		return $OrderDetails;

	}

	Public function ReturnUserOrders($username){

		return $this->GetUserOrders($username);
	}

	Public function ReturnOrderByID($OrderId){   // For Testing Purpose IDOR

		if ($this->CheckOrderDB($OrderId) !== True){

			return False;
			exit();
		}

		return $this->GetOrderById($OrderId);
	}


}



?>