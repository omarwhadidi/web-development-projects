<?php 
		

	require '../../public/includes/libraries/PHPMailer/src/Exception.php'; 
	require '../../public/includes/libraries/PHPMailer/src/PHPMailer.php'; 
	require '../../public/includes/libraries/PHPMailer/src/SMTP.php'; 


	include '../../src/core/config.php' ;
	include '../../src/core/database.php' ;
	include '../../src/core/functions.php';
	include '../../src/core/validation.php';
	include '../../src/core/session.php';
	include '../../src/core/token.php';

	require '../../src/model/Admin.classes.php';
	require '../../src/controller/AdminContr.classes.php';
	require '../../src/model/Login.classes.php';
	require '../../src/controller/LoginContr.classes.php';
	require '../../src/model/Product.classes.php';
	require '../../src/controller/ProductContr.classes.php';
	require '../../src/model/SignUp.classes.php';
	require '../../src/controller/SignUpContr.classes.php';
	require '../../src/model/Customer.classes.php';
	require '../../src/controller/CustomerContr.classes.php';
	require '../../src/model/Reset.classes.php';
	require '../../src/controller/ResetContr.classes.php';
	require '../../src/model/Update.classes.php';
	require '../../src/controller/UpdateContr.classes.php';

/*	// AutoLoad Classes 
	spl_autoload_register(function($class){

		if (strpos($class, 'Contr') !== false) {
		    require '../../src/controller/'.$class.'.classes.php';
		}
		else {
			require '../../src/model/'.$class.'.classes.php';
		}
	});*/

	



	
?>
