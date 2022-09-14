<?php   
include '../src/init.php';
include TPL_PATH.'header.inc.php';
include TPL_PATH.'navbar.inc.php';

use Ecommerce\Controller\Auth As Auth;

if (isset($_POST['Register'])){

    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
        


        $SignUp = new Auth\SignUpContr();
        $CatpchaResult = $SignUp->CaptchaCheck();

        if ($CatpchaResult == True ){

              $FullName  = $_POST['name'];
              $UserName  = $_POST['username'];
              $Email  = $_POST['email'];
              $Password  = $_POST['password'];
              $ConfirmPassword  = $_POST['password2'];
              $Client_ip  = $_SERVER['REMOTE_ADDR'];
              $useragent = $_SERVER['HTTP_USER_AGENT'];

              
             $Regmsg = $SignUp->SignUpProcess($FullName,$UserName,$Email,$Password,$ConfirmPassword,$Client_ip,$useragent);
              $Regmsg;

        }
        else {
            $Regmsg = '<div class="alert alert-danger"> Robot verification failed, please try again </div>.';
            //die($$msg);
        }   // If Codition Failed Recaptcha

      }
      else {

        $Regmsg = '<div class="alert alert-danger"> Robot verification failed , please try again </div>.';
        //die($$msg);

      }  // If Codition Recaptcha
          

}

if (isset($_POST['Login'])){

  $Email  = $_POST['email'];
  $Password  = $_POST['password'];
  $RememberMe = isset($_POST['rememberme']) ? 'True' : 'False';
  $Client_ip  = $_SERVER['REMOTE_ADDR'];
  $useragent = $_SERVER['HTTP_USER_AGENT'];

  if(isset($_POST['login_token']) && $_POST['login_token'] == $_SESSION['logout_token']) {

      $Auth->SetParams($Email,$Password,$RememberMe,$Client_ip,$useragent);
      $Logmsg = $Auth->SignInUser($Email);

  }
  else {
          // show an error message
      echo  'Error: invalid Link ';
      // return 405 http status code
      header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
  }

}


/*if (isset($_SESSION['redirect_after_login'])){
  if(isset($_SERVER['HTTP_REFERER'])) {
    $_SESSION['referer'] = $_SERVER['HTTP_REFERER'];  // open redirect via referer header
    echo $_SERVER['HTTP_REFERER']; 
  }
}*/

   ?>

 
  <!-- catg header banner section -->
  <section id="aa-catg-head-banner">
    <img src="assets/img/fashion/fashion-header-bg-8.jpg" alt="fashion img">
    <div class="aa-catg-head-banner-area">
     <div class="container">
      <div class="aa-catg-head-banner-content">
        <h2>Account Page</h2>
        <ol class="breadcrumb">
          <li><a href="index.php">Home</a></li>                   
          <li class="active">Account</li>
        </ol>
      </div>
     </div>
   </div>
  </section>
  <!-- / catg header banner section -->

 <!-- Cart view section -->
 <section id="aa-myaccount">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
        <div class="aa-myaccount-area">         
            <div class="row">
              <div class="col-md-6">
                <div class="aa-myaccount-login">
                <h4>Login</h4>
                 <form action="" method="POST" class="aa-login-form" autocomplete="off">
                  <label for="">Email address<span>*</span></label>
                   <input type="text" name="email" placeholder="Username or email">
                   <label for="">Password<span>*</span></label>
                    <input type="password" name="password" placeholder="Password" autocomplete="new-password">
                    <input type="hidden" name="login_token" value="<?php echo $Login_token; ?>"/>
                    <button type="submit" name="Login" class="aa-browse-btn">Login</button>
                    <label class="rememberme" for="rememberme"><input type="checkbox" name="rememberme" value="True" id="rememberme"> Remember me </label>
                    <p class="aa-lost-password"><a href="forgetpassword.php">Lost your password?</a></p>
                  </form>   
                    <?php if (isset($Logmsg)){echo '<div class= "alert alert-danger" style="margin-top:80px;" >'.$Logmsg.'</div>';} ?>
                </div>
              </div>
              <div class="col-md-6">
                <div class="aa-myaccount-register">                 
                 <h4>Register</h4>
                 <form action="<?php echo $_SERVER['PHP_SELF'];?>"  method="POST" class="aa-login-form" autocomplete="off">
                    <label for="">Full Name<span>*</span></label>
                    <input type="text" name="name" placeholder="Full Name" >
                    <label for="">Email address<span>*</span></label>
                    <input type="text" name="email" placeholder="Email">
                    <label for="">Username<span>*</span></label>
                    <input type="text" name="username" placeholder="Username">
                    <label for="">Password<span>*</span></label>
                    <input type="password" name="password" placeholder="Password" autocomplete="new-password">
                    <label for="">Confirm Password<span>*</span></label>
                    <input type="password" name="password2" placeholder="Confirm Password" autocomplete="new-password">
                    <div class="g-recaptcha" data-sitekey="6LfllAAeAAAAAMWDOnE9Lw_8QLALST5tG2ldTVvD">  
                    </div>
                    <button type="submit" name="Register" class="aa-browse-btn">Register</button>
                  </form>
                    <div style="margin-top:80px;" ><?php if (isset($Regmsg)){echo $Regmsg;} ?> </div>
                </div>

              </div>
            </div>          
         </div>
       </div>
     </div>
   </div>
 </section>
 <!-- / Cart view section -->
<?php include TPL_PATH.'footer.inc.php'; ?>