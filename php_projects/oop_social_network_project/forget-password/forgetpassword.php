<?php

include '../classes/dbh.classes.php';
include '../classes/model/reset.classes.php';
include '../classes/controller/reset-contr.classes.php';

if (isset($_POST['submit'])){ 
  
  // initializing Variables

  $email = $_POST['email'] ;

  
  $reset = new ResetContr();

  $reset->SetEmail($email);
  $reset->SetToken();

  $error = $reset->GetResetLink();

}



?>
<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
   <style type="text/css">
     
      body {
       background-position: center;
       background-color: #eee;
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
           padding-bottom: 72px !important
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
</head>
<body>
    <div class="container padding-bottom-3x mb-2 mt-5">
      <div class="row justify-content-center">
          <div class="col-lg-8 col-md-10">
              <div class="forgot">
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
                  <div class="card-footer"> <button class="btn btn-success" type="submit" name="submit" >Get New Password</button> <a class="btn btn-danger" href="../index.php">Back to Login</a> </div>
              </form>
              <?php if (isset($error) && !empty($error)){
                echo $error;
              }
              ?>
          </div>
      </div>
  </div>
  <?php include '../includes/templates/footer.inc.php'; ?>
</body>

