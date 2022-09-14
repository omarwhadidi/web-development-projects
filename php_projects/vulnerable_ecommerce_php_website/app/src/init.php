<?php 

	require '../public/includes/libraries/PHPMailer/src/Exception.php'; 
	require '../public/includes/libraries/PHPMailer/src/PHPMailer.php'; 
	require '../public/includes/libraries/PHPMailer/src/SMTP.php'; 


	require 'core/config.php' ;
	require 'core/database.php' ;
	require 'core/functions.php';
	require 'core/validation.php';
	require 'core/session.php';
	require 'core/token.php';

/*	require 'model/Login.classes.php';
	require 'controller/LoginContr.classes.php';
	require 'model/Product.classes.php';
	require 'controller/ProductContr.classes.php';
	require 'model/SignUp.classes.php';
	require 'controller/SignUpContr.classes.php';
	require 'model/Customer.classes.php';
	require 'controller/CustomerContr.classes.php';
	require 'model/Reset.classes.php';
	require 'controller/ResetContr.classes.php';
	require 'model/Update.classes.php';
	require 'controller/UpdateContr.classes.php';
*/



// AutoLoad Classes with namespaces
spl_autoload_register(function($className) {
	// Adapt this depending on your directory structure
    $parts = explode('\\', $className);
    
	if (strpos($className, 'Contr') !== false) {
	    require 'controller/'.end($parts).'.classes.php';
	}
	else {
		require 'model/'.end($parts).'.classes.php';
	}

});

/*	// AutoLoad Classes without namespaces
	spl_autoload_register(function($class){

		if (strpos($class, 'Contr') !== false) {
		    require 'controller/'.$class.'.classes.php';
		}
		else {
			require 'model/'.$class.'.classes.php';
		}
	});*/

	// Note: Linux is Case Sensitive Unlike Windows make sure all Files are Capitalized same as Class Names


	
?>
