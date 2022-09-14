<?php
require '../src/init.php';
include TPL_PATH.'header.inc.php';


if (isset($_POST['logout']) ){

	if(isset($_POST['logout_token']) && $_POST['logout_token'] == $_SESSION['logout_token']) {

		$Auth->Logout();

	}
	else {
		
		// show an error message
	    echo '<p class="error">Error: Logout Failed Bad link</p>';
	    // return 405 http status code
	    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
	    exit;
	}

}

ob_end_flush(); // Fix Headers Already Sent Error

?>