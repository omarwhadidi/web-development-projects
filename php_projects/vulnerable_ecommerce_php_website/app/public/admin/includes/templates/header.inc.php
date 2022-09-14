<?php
ob_start();    // Fix Headers Already Sent Error (First Thing in the Page)
session_start();

use Ecommerce\Controller\Admin As Admin;
use Ecommerce\Controller\Auth As Auth;
use Ecommerce\Controller\User As User;
use Ecommerce\Controller\Product As Product;

$Admin = new Admin\AdminContr();
$Auth = new Auth\LoginContr();
$Product = new Product\ProductContr();
$Customer = new User\CustomerContr();





// ----------------------------------- Session Validation --------------------------------------

$Auth->ValidateAdminSession();
$Auth->ValidateLogoutTokenSession();
$Login_token = $_SESSION['logout_token']; 

if(isset($_SESSION['loggedin']) && !isset($_COOKIE['usersession']) ){
  
  $Auth->LimitSessionDuration();
}


$CookieCheck = $Auth->CheckCookie();

if ($CookieCheck == True){
  echo 'Cookie name: '.$_SESSION['username']; 
}
      

if(isset($_SESSION['loggedin']) && isset($_SESSION['isadmin']) ){
    echo 'Session name: '.$_SESSION['username']; 
    $UserSession = $_SESSION['username']; 
}

// ----------------------------------- Session Validation --------------------------------------



?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <title>Daily Shop | Home</title>
    
    <!-- Font awesome -->
    <link rel="stylesheet" href="../assets/css/font-awesome.css" >
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../assets/css/bootstrap.css" >   
    <!-- SmartMenus jQuery Bootstrap Addon CSS -->
    <link rel="stylesheet" href="../assets/css/jquery.smartmenus.bootstrap.css" >
    <!-- Product view slider -->
    <link rel="stylesheet" type="text/css" href="../assets/css/jquery.simpleLens.css">    
    <!-- slick slider -->
    <link rel="stylesheet" type="text/css" href="../assets/css/slick.css">
    <!-- price picker slider -->
    <link rel="stylesheet" type="text/css" href="../assets/css/nouislider.css">
    <!-- Theme color -->
    <link id="switcher" href="../assets/css/theme-color/default-theme.css" rel="stylesheet">
    <!-- <link id="switcher" href="../assets/css/theme-color/bridge-theme.css" rel="stylesheet"> -->
    <!-- Top Slider CSS -->
    <link href="../assets/css/sequence-theme.modern-slide-in.css" rel="stylesheet" media="all">

    <!-- Main style sheet -->
    <link href="../assets/css/style.css" rel="stylesheet">    

    <!-- Google Font -->
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  

  </head>
  <body> 
  <!-- Start header section -->
  <header id="aa-header">
    <!-- start header top  -->
    <div class="aa-header-top">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="aa-header-top-area">
              <!-- start header top left -->
              <div class="aa-header-top-left">
                <!-- start language -->
                <div class="aa-language">
                  <div class="dropdown">
                    <a class="btn dropdown-toggle" href="#" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                      <img src="../assets/img/flag/english.jpg" alt="english flag">ENGLISH
                      <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                      <li><a href="#"><img src="../assets/img/flag/french.jpg" alt="">FRENCH</a></li>
                      <li><a href="#"><img src="../assets/img/flag/english.jpg" alt="">ENGLISH</a></li>
                    </ul>
                  </div>
                </div>
                <!-- / language -->

                <!-- start currency -->
                <div class="aa-currency">
                  <div class="dropdown">
                    <a class="btn dropdown-toggle" href="#" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                      <i class="fa fa-usd"></i>USD
                      <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                      <li><a href="#"><i class="fa fa-euro"></i>EURO</a></li>
                      <li><a href="#"><i class="fa fa-jpy"></i>YEN</a></li>
                    </ul>
                  </div>
                </div>
                <!-- / currency -->
                <!-- start cellphone -->
                <div class="cellphone hidden-xs">
                  <p><span class="fa fa-phone"></span>00-62-658-658</p>
                </div>
                <!-- / cellphone -->
              </div>
              <!-- / header top left -->
              <div class="aa-header-top-right">
                <ul class="aa-head-top-nav-right">
                    <li class="hidden-xs">
                      <form method="GET">
                        <button name="action" value="feedbacks" style="background-color: #FFF;border:none;border-right: solid 1px ">User Messages</button>
                      </form>
                    </li>
                    <li class="hidden-xs">
                      <form method="GET">
                        <button name="action" value="orders" style="background-color: #FFF;border:none;border-right: solid 1px ">orders</button>
                      </form>
                    </li>
                    <li class="hidden-xs">
                      <form method="GET">
                        <button name="action" value="users" style="background-color: #FFF;border:none;border-right: solid 1px ">Users</button>
                      </form>
                    </li>    
                    <li class="hidden-xs">
                      <form method="GET">
                        <button name="action" value="products" style="background-color: #FFF;border:none;border-right: solid 1px ">Products</button>
                      </form>
                    </li>
                    <li><a href="" data-toggle="modal" data-target="#login-modal">Login</a></li>
                    <li class="hidden-xs">                      
                      <form action="../logout.php" method="POST">
                       <input type="hidden" name="logout_token" value="<?php echo $Login_token; ?>" />
                        <button type="submit" name="logout" value="logout" style="background-color: #FFF;border:none;">Logout</button>
                      </form>
                    </li>  
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- / header top  -->

    <!-- start header bottom  -->
    <div class="aa-header-bottom">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="aa-header-bottom-area">
              <!-- logo  -->
              <div class="aa-logo">
                <!-- Text based logo -->
                <a href="../index.php">
                  <span class="fa fa-shopping-cart"></span>
                  <p>daily<strong>Shop</strong> <span>Your Shopping Partner</span></p>
                </a>
                <!-- img based logo -->
                <!-- <a href="index.php"><img src="../assets/img/logo.jpg" alt="logo img"></a> -->
              </div>
              <!-- / logo  -->

<!--                search box 
              <div class="aa-search-box">
                <form action="">
                  <input type="text" name="" id="" placeholder="Search here ex. 'man' ">
                  <button type="submit"><span class="fa fa-search"></span></button>
                </form>
              </div>
               / search box    -->           
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- / header bottom  -->
  </header>
  <!-- / header section -->


  <!-- Login Modal -->  
  <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">                      
        <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4>Login or Register</h4>
          <form class="aa-login-form" action="register.php" method="POST">
            <label for="">Username or Email address<span>*</span></label>
            <input type="text" placeholder="email" name="email">
            <label for="">Password<span>*</span></label>
            <input type="password" placeholder="Password" name="password">
            <button class="aa-browse-btn" type="submit" name="Login" value="Login">Login</button>
            <label for="rememberme" class="rememberme"><input type="checkbox" id="rememberme" name="rememberme" value="True"> Remember me </label>
            <p class="aa-lost-password"><a href="forgetpassword.php">Lost your password?</a></p>
            <div class="aa-register-now">
              Don't have an account?<a href="register.php">Register now!</a>
            </div>
          </form>
        </div>                        
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div> 