<?php   
    include '../src/init.php';
    include TPL_PATH.'header.inc.php';

use Ecommerce\Controller\Auth As Auth;
$reset = new Auth\ResetContr();

if (isset($_POST['submit'])){ 
	  
	  // initializing Variables
	  $Email = $_POST['email'] ;

	  $ReturnMsg = $reset->GetResetLink($Email);

}

?>

<style type="text/css">
     
      body {
       background-position: center;
       
       background-repeat: no-repeat;
       background-size: cover;
       color: #505050;
       font-family: "Rubik", Helvetica, Arial, sans-serif;
       font-size: 14px;
       font-weight: normal;
       line-height: 1.5;
       text-transform: none
     } 

       .forgot {
           background-color: #fff;
           padding: 12px;
           border: 1px solid #dfdfdf
       }

       .padding-bottom-3x {
           padding: 100px  100px !important;
           
       }

       .card-footer {
           background-color: #fff
       }

       .btn {
           font-size: 13px
       }

       .form-control:focus {
           color: #495057;
           background-color: #fff;
           border-color: #76b7e9;
           outline: 0;
           box-shadow: 0 0 0 0px #28a745
       }
    </style>

<body>
    <div class="container padding-bottom-3x mb-2 mt-5">
      <div class="row justify-content-center">
          <div class="col-lg-8 col-md-10">
              <div class="forgot ">
                  <h2>Forgot your password?</h2>
                  <p>Change your password in three easy steps. This will help you to secure your password!</p>
                  <ol class="list-unstyled">
                      <li><span class="text-primary text-medium">1. </span>Enter your email address below.</li>
                      <li><span class="text-primary text-medium">2. </span>Our system will send you a temporary link</li>
                      <li><span class="text-primary text-medium">3. </span>Use the link to reset your password</li>
                  </ol>
              </div>
              <form class="card mt-4" method="POST" action="">
                  <div class="card-body">
                      <div class="form-group"> <label for="email-for-pass">Enter your email address</label> <input class="form-control" type="text" id="email-for-pass" name="email" ><small class="form-text text-muted">Enter the email address you used during the registration on BBBootstrap.com. Then we'll email a link to this address.</small> </div>
                  </div>
                  <div class="card-footer"> <button class="btn btn-success" type="submit" name="submit" >Get New Password</button> <a class="btn btn-danger" href="index.php">Back to Login</a> </div>
              </form>
              <div>
              		<?php if (isset($ReturnMsg) && !empty($ReturnMsg)){
		                echo $ReturnMsg;
		              }
		             ?>
          	</div>
          </div>
      </div>
  </div>


<?php     include TPL_PATH.'footer.inc.php'; ?>