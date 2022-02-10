<?php 
ob_start();    // Fix Headers Already Sent Error (First Thing in the Page)
	/*  
	php Application Features
	   1- Object Oriented Programig 
	   2- Site Functions: 
	   	  - Login / Logout / Register / Update user Data
	   	  - Share / Like / Delete Posts
	   	  - Email Verification (PHPMailer)
	   	  - Password Reset 
	   	  - Remember me Function 
	   	  - File Upload 
	   	  - Logging System
	   	  - Live Search With XHR
	      - OAuth *
	      - websocket chat *
	      - Prevent Brute Forcing 
	      	- Recaptcha in Register page
	      	- account lockout  (in login page)
	      - Prevent User Enumeration 
	      	- Recaptcha in Register page
	      	- in Password Reset Page (send email anyway) 
	      	- General Error messages in login page
	   3- Session Managment : 
	      - Prevent Session Fixation      (session_regenerate_id())
	      - Decrease Session Hijacking    (Limited inactive session Duration)   
	      - Encrypted cookies 
	   4- Authorization : 
	      - Admin Panel Features 
	   5- Users Vulnerabilities
	   	  - Prevent Unvalidated Redirection [exit() after each Redirection] 
	      - Prevent CSRF
	      	- CSRF Token 
	      	- CSRF login/logout 
	      - Prevent xss
	          - Disable auto-complete Feature (autocomplete="off" && autocomplete="new-password")
	    6- Databases Features:
	    	- Store Encrypted Password in Database 
	    	- Prevent SQL Injection
	        	- Use Prepared Statements
	        	- Make a Different User (Dont use Root)
		7- Extra
			- Add Security Headers in Responses 
			- Add Custom Error Page
  */

require 'includes/core/config.php';
include 'classes/dbh.classes.php';
include 'classes/model/login.classes.php';
include 'classes/controller/login-contr.classes.php';

session_start();

if (!isset($_SESSION['login_token'])) {   
	$_SESSION['login_token'] = bin2hex(random_bytes(32));  // Prevent CSRF Login/Logout 
}

$token = $_SESSION['login_token']; 
$errors=false;

$signin = new LoginContr();
$signin->CheckUserCookie();


if (isset($_POST['submit'])){ 
	
	// initializing Variables

	$Username = $_POST['username'] ;
	$Password = $_POST['password'] ;

	// Login CSRF 
    
    if($_POST['login_token'] == $_SESSION['login_token']) {

        // Validate user 

		$signin->SetParams($Username,$Password);

		$errors = $signin->SignInCheck();

		if  (!$errors){

			if(isset($_POST['rememberme']) && $_POST['rememberme'] == true) {

		        $signin->SetCookie($Username);

			}
			unset($_SESSION['login_token']);

			$signin->SignInUser($Username);

		}

    }
    else {

    	// show an error message
	    $errors = 'Error: invalid Link ';
	    // return 405 http status code
	    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    }
    
	


}
     

?>
<html>
	<head lang="en-us">
		<title>social</title>
		                              <!--META TAGS -->
		<meta charset="utf-8" />
		<meta name="description" content="Connect with friends and pentesters and other people you know. Share photos and videos, send messages and get updates." />
		<meta name="keyword" content="flagx , flag , social , network , social network , connect , " />
		<meta name="author" content="OMar El Hadidi"  />
		<meta name="robots" content="index,follow" />
		<meta name="viewport" content="width=device-width,initial-scale=1.0" />


										<!--LNIK TAGS -->
		 
		<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
					<!--FONTAWESOME FILE -->
		
										<!--fav icons  -->
		<link rel="icon" href="images/favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
		<link rel="apple-touch-icon" href="">  						<!--APPLE FAVICONS -->

		<style type="text/css">
			
			.divider:after, .divider:before {
			  content: "";
			  flex: 1;
			  height: 1px;
			  background: #eee;
			}
			.h-custom {
			  height: calc(100% - 73px);
			}
			@media (max-width: 450px) {
			  .h-custom {
			    height: 100%;
			  }
			}

		</style>

	</head>
	<body>
		<section class="vh-100">
		  <div class="container-fluid h-custom">
		    <div class="row d-flex justify-content-center align-items-center h-100">
		      <div class="col-md-9 col-lg-6 col-xl-5">
		        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp" class="img-fluid"
		          alt="Sample image">
		      </div>
		      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
		        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>" autocomplete="off">
		          <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
		            <p class="lead fw-normal mb-0 me-3">Sign in with</p>
		            <button type="button" class="btn btn-primary btn-floating mx-1">
		              <i class="fa fa-facebook-f"></i>
		            </button>

		            <button type="button" class="btn btn-primary btn-floating mx-1">
		              <i class="fa fa-twitter"></i>
		            </button>

		            <button type="button" class="btn btn-primary btn-floating mx-1">
		              <i class="fa fa-linkedin"></i>
		            </button>
		          </div>

		          <div class="divider d-flex align-items-center my-4">
		            <p class="text-center fw-bold mx-3 mb-0">Or</p>
		          </div>

		          <!-- Email input -->
		          <div class="form-outline mb-4">
		            <input type="text" id="form3Example3" class="form-control form-control-lg"
		               name="username" placeholder="Enter a valid username" autocomplete="off" />
		            <label class="form-label" for="form3Example3"></label>
		          </div>

		          <!-- Password input -->
		          <div class="form-outline mb-3">
		            <input type="password" id="form3Example4" class="form-control form-control-lg"
		              name="password" placeholder="Enter password" autocomplete="new-password" />
		             <input type="hidden" name="login_token" value="<?php echo $token; ?>"/>
		            <label class="form-label" for="form3Example4"></label>
		          </div>

		          <div class="d-flex justify-content-between align-items-center">
		            <!-- Checkbox -->
		            <div class="form-check mb-0">
		              <input class="form-check-input me-2" type="checkbox" name="rememberme" Value="true" id="form2Example3" />
		              <label class="form-check-label" for="form2Example3">
		                Remember me
		              </label>
		            </div>
		            <a href="forget-password/forgetpassword.php" class="text-body">Forgot password?</a>
		          </div>

		          <div class="text-center text-lg-start mt-4 pt-2">
		            <button type="submit" class="btn btn-primary btn-lg"
		              name="submit" value="login" style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
		            <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="register.php"
		                class="link-danger">Register</a></p>
		          </div>

		        </form>
		        <?php if($errors){
		        	echo '<div class="alert alert-warning alert-dismissable"  role="alert">
				          <a class="panel-close close" data-dismiss="alert">×</a> 
				          <i class="fa fa-coffee"></i> '.$errors.'
		        		  </div>'; 
		        }?>
		        
		        
		      </div>
		    </div>
		  </div>
		  <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
		    <!-- Copyright -->
		    <div class="text-white mb-3 mb-md-0">
		      Copyright © 2020. All rights reserved.
		    </div>
		    <!-- Copyright -->

		    <!-- Right -->
		    <div>
		      <a href="#!" class="text-white me-4">
		        <i class="fa fa-facebook-f"></i>
		      </a>
		      <a href="#!" class="text-white me-4">
		        <i class="fa fa-twitter"></i>
		      </a>
		      <a href="#!" class="text-white me-4">
		        <i class="fa fa-google"></i>
		      </a>
		      <a href="#!" class="text-white">
		        <i class="fa fa-linkedin"></i>
		      </a>
		    </div>
		    <!-- Right -->
		  </div>
		</section>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	</body>
	</html>

<?php 




/* 
1- Encapsulation is a mechanism that prohibit Accesing (reading or changing ) the properties inside the class Directly But can only be accessed through class Methods , which means the variables (properties) of a class will be hidden from other classes, and can be accessed only through the methods of their current class. Therefore, it is also known as data hiding . 
These Methods are called  setters and getters As the names indicate, a getter method retrieves an attribute and a setter method changes it. Depending on the methods that you implement, you can decide if an attribute can be read and changed. briefly you cannnot read or change the properties of the class without the setters and getters methods .
	To achieve encapsulation in OOP :
		- Declare the variables of a class as private.
		- Provide public setter and getter methods to modify and view the variables values.

- Visibility Markers = 
 		- Public
 		- Protected
 		- Private


2- 
Inheritance is the procedure in which one class inherits the attributes and methods of another class . The class whose properties and methods are inherited is known as the superclass, or parent class. And the class that inherits the properties from the parent class is called the subclass, or child class . 
Also along with the inherited properties and methods, a child class can have its own properties and methods.
	- the keyword "extends" is used by the sub class to inherit the features of super class.
	class subClass extends superClass  
	{  
	   //methods and fields  
	}
- Method Overriding
	The concept of overriding is very important in inheritance. It gives the special ability to the child/subclasses to provide specific implementation to a method that is already present in their parent classes.
	If you want to Prevent a method from being overridden or If you want to make sure that no subclass can change the implementation of a method, you can declare it to be "final". 
	final public function anyfn(){
		// some code 
	}
	if you added the Final Keywork to a class you cannot inherit from that class
	Final class className
	{  
	   //methods and fields  
	}



3- Polymorphism : Inheritance not only adds all public and protected methods of the superclass to your subclass, but it also allows you to replace their implementation. The method of the subclass then overrides the one of the superclass. That mechanism is called polymorphism.

4- Data abstraction 
	- cannot be innitiated (cannot make objects from abstract classes)
	- Made for  other classes inheret properties and methods from its 
	- You use the keyword abstract to declare a class or method to be abstract.
		abstract class ClassName {
			//methods and fields
		}
	- An abstract class doesn’t need to contain any abstract methods. But an abstract method needs to be declared by an abstract class.
	- in abstract classes you it can be used to initialize your properties and Methods but best practise that the methods have empty bodies and then write the bodies of these methods in the inhereted classes
		abstract class ClassName {
			protected prop1;
			protected prop2;
			
			abstract public function fnname1();
			abstract Protected function fnname2($arg,$arg2);
		}


*/

	
?>