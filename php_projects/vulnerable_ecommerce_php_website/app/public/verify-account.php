<?php
require '../src/init.php';
include TPL_PATH.'header.inc.php';
include TPL_PATH.'navbar.inc.php';

use Ecommerce\Controller\Auth As Auth;

if (isset($_GET['verify_token'])){
	
	$verify_token = $_GET['verify_token'];
	

	$verifySignUp = new Auth\SignUpContr();

	if ($verifySignUp->ActivateAccount($verify_token)){

		echo '
			<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
			<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
			<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
			<body>
			    <div class="container">
			        <div class="jumbotron text-center">
			            <h1 class="display-4">Account Verified Successfully</h1>
			            <div class="col-12 mb-5 text-center">
			            </div>
			            <p class="lead">your Account has Been Verified you will be Redirect shortly to the login page Or Press on the login Button </p>
			            <a class="btn btn-lg btn-success" href="register.php">Click to Login
			            </a>
			        </div>
			    </div>
			</body>';
			
			$page = 'register.php';
            $sec = "5";
            header("Refresh: $sec; url=$page");
	}

	else {

		echo 'Error Account Not Verified ';
	}

	

}
else {

		// show an error message
	    echo '<p class="error">Error: invalid Link </p>';
	    // return 405 http status code
	    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
}

include TPL_PATH.'footer.inc.php';

?>