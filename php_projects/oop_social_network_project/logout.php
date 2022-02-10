<?php

ob_start();
session_start();

require 'includes/core/config.php';
include 'classes/dbh.classes.php';
include 'classes/model/user.classes.php';
include 'classes/controller/user-contr.classes.php';


$user= new UserContr();

if (isset($_POST['logouttoken']) && $_POST['logouttoken'] == $_SESSION['logout_token']){

	$user->Logout();

}
else {
	
	// show an error message
    echo '<p class="error">Error: Logout Failed Bad link</p>';
    // return 405 http status code
    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    exit;
}



ob_end_flush(); // Fix Headers Already Sent Error

?>