<?php 
ob_start();  // Fix Headers Already Sent Error (First Thing in the Page)
?>
<!DOCTYPE html>
<html>
<head>
    <title>PHP User Registration System Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="layout/css/register.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer ></script>
</head>
<body>
 <div>
                    
    <?php if (isset($msg)){echo $msg;} ?>
</div>
    <div class="App">
        <div class="vertical-center">
            <div class="inner-block" style="padding-top:142px">
                <form action="" method="post" autocomplete="off">
                    <h3>Register</h3>
                     <div class="form-group">
                        <label>Full Name </label>
                        <div class="input-group">
                            <input style="width:50% " class="form-control " placeholder="First name"  name="firstname" type="text" />
                            <input style="width:50% " class="form-control " placeholder="Last Name"  name="lastname" type="text" />
                        </div>
                        

                    </div> 
                    <div class="form-group">
                        <label>Username </label>
                        <input type="text" class="form-control" name="username" id="firstName" placeholder="username"/>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email"/>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" id="mobilenumber" autocomplete="new-password" placeholder="Password"/>
                    </div>

                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" name="password2" id="password" autocomplete="new-password" placeholder="Confirm Paasord" />
                    </div>
                      <div class="form-group">
                        <label>Gender </label></br>
                        <label>Male</label>
                        <input type="radio"  name="gender" value="male"/>
                        <label>Female</label>
                        <input type="radio"  name="gender" value="Female" />
                    </div>
                    <div class="g-recaptcha" data-sitekey="6LfllAAeAAAAAMWDOnE9Lw_8QLALST5tG2ldTVvD">
                        
                    </div>
                    </br>

                    <button type="submit" name="submit" id="submit" class="btn btn-outline-primary btn-lg btn-block">
                        Sign up
                    </button>
                     
                   
                </form>
                 </br>
                <div class="d-flex justify-content-center">
                   <a href="index.php"  id="submit" class="link-primary text-center">Already Have An Account?</a>
                </div>
                 
               
                
            </div>
        </div>
    </div>

        <!-- jQuery + Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
<?php 

include 'includes/core/config.php';
include 'classes/dbh.classes.php';
include 'classes/model/signup.classes.php';
include 'classes/controller/signup-contr.classes.php';



if (isset($_POST['submit'])){

        if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
            $secret = '6LfllAAeAAAAAEt_EiW5f53wbftGYyPQShQRdMdn';
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
            $responseData = json_decode($verifyResponse);
            if($responseData->success){

                    // initializing Variables
                    $FirstName =$_POST['firstname'] ;
                    $LastName = $_POST['lastname'] ;
                    $Username = $_POST['username'] ;
                    $Email = $_POST['email'] ;
                    $Password = $_POST['password']  ;
                    $Password2 = $_POST['password2'] ;
                    $Gender = $_POST['gender'] ;
                    $client_ip = $_SERVER['REMOTE_ADDR'];

                    // Validate and sign up

                    $create = new SignUpContr($FirstName,$LastName,$Username,$Email,$Password,$Password2,$Gender,$client_ip);

                    $insert = new SignUp();

                    $Result = $create->CreateUser();

                    if ($Result ){

                        header('Location: register.php?user='.$Result) ;
                    }
                    else {

                        echo $create->SendEmail($Email);

                    }


            }
            else {
                $errMsg = 'Robot verification failed, please try again.';
                die($errMsg);
            }   // If Codition Failed Recaptcha

      }
      else {

        $errMsg = 'Robot verification failed, please try again.';
        die($errMsg);

      }  // If Codition Recaptcha



}

ob_end_flush(); // Fix Headers Already Sent Error
?>