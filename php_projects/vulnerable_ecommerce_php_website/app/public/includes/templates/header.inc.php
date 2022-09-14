<?php
ob_start();    // Fix Headers Already Sent Error (First Thing in the Page)
session_start();



use Ecommerce\Controller\Auth As Auth;
use Ecommerce\Controller\User As User;
use Ecommerce\Controller\Product As Product;

$Auth = new Auth\LoginContr();
$Product = new Product\ProductContr();
$Customer = new User\CustomerContr();

$CookieCheck = $Auth->CheckCookie();

if ($CookieCheck == True){
  $UserCookie = 'Cookie name: '.$_SESSION['username']; 
}
      
$UserSession='Guest';

if(isset($_SESSION['loggedin'])){
    $UserSession = $_SESSION['username'];
    $UserDetails = $Customer->GetUserDetails($UserSession); 

}

$Auth->ValidateLogoutTokenSession();
$Login_token = $_SESSION['logout_token']; 


if (isset($_POST['addtocart']) && !empty($_POST['pid']) ){

  $product_id = $_POST['pid'];

  $Result = $Customer->AddToCart($product_id);

  if ($Result !== True){
    
     $AddToCartResult = $Result;
  
  }

}


// Remove product from cart
if (isset($_REQUEST['RemoveFromCart']) && is_numeric($_REQUEST['pid']) ) {

    $pid = $_REQUEST['pid'] ;
    $result = $Customer->RemoveFromCart($pid);
   
    if ($result !== True){
        echo '<script>alert("Error Removing From Cart")</script>';
    }
}

// empty the cart
if (isset($_POST['EmptyCart'])) {
    
    $result = $Customer->EmptyCart();

    if ($result !== True){
      $EmptyCartResult = 'Error ';
    }
}




 //echo $productContr->GenerateCoupon(10);
if (isset($_POST['ApplyCoupon']) ) {

    $coupon_code = $_POST['coupon'] ;
    $CouponCheck = $Customer->ValidateCoupon($coupon_code,$UserSession);
    
    if ($CouponCheck === True){

      $CouponResult = $Customer->ApplyCoupon($coupon_code) ;
    }
    else {
      $CouponError = $CouponCheck;
    }

}



 if(isset($_SESSION['cart'])){
  //echo 'Cart : ';
  //var_dump($_SESSION['cart']) ; 
  $CartProducts = $_SESSION['cart'];

}

if(isset($_SESSION['discount'])){
  
  $discount = $_SESSION['discount'];

}

$CartQty = 0;
$total = 0;

if (isset($CartProducts)){
  foreach ($CartProducts as $CartProduct) {         
      $CartQty ++;
      $ProductDetails = $Product->GetProductsByID($CartProduct['pid']);
      $total += $ProductDetails['price'] * $CartProduct['qty'];
  }

}



// Send the user to the place order page if they click the Place Order button, also the cart should not be empty
if (isset($_POST['checkout']) ) {

  if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
    header('Location: checkout.php');
    exit();
  }
  else {
    $msg = 'please Add Items To your Cart';

  }

}


?>


<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <title>Daily Shop | Home</title>
    
    <!-- Font awesome -->
    <link href="assets/css/font-awesome.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">   
    <!-- SmartMenus jQuery Bootstrap Addon CSS -->
    <link href="assets/css/jquery.smartmenus.bootstrap.css" rel="stylesheet">
    <!-- Product view slider -->
    <link rel="stylesheet" type="text/css" href="assets/css/jquery.simpleLens.css">    
    <!-- slick slider -->
    <link rel="stylesheet" type="text/css" href="assets/css/slick.css">
    <!-- price picker slider -->
    <link rel="stylesheet" type="text/css" href="assets/css/nouislider.css">
    <!-- Theme color -->
    <link id="switcher" href="assets/css/theme-color/default-theme.css" rel="stylesheet">
    <!-- <link id="switcher" href="assets/css/theme-color/bridge-theme.css" rel="stylesheet"> -->
    <!-- Top Slider CSS -->
    <link href="assets/css/sequence-theme.modern-slide-in.css" rel="stylesheet" media="all">

    <!-- Main style sheet -->
    <link href="assets/css/style.css" rel="stylesheet">    

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
                      <img src="assets/img/flag/english.jpg" alt="english flag">ENGLISH
                      <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                      <li><a href="#"><img src="assets/img/flag/french.jpg" alt="">FRENCH</a></li>
                      <li><a href="#"><img src="assets/img/flag/english.jpg" alt="">ENGLISH</a></li>
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
                  <?php if (isset($_SESSION['loggedin'])) {
                    echo '<li class="hidden-xs"><a href="orders.php">My orders</a></li>';
                   }  ?>
                  <?php if (isset($_SESSION['loggedin'])) {
                    echo '<li><a href="account.php">My Account</a></li>';
                   }  ?>
                  <li class="hidden-xs"><a href="cart.php">My Cart</a></li>
                  <li><a href="" data-toggle="modal" data-target="#login-modal">Login</a></li>
                  <?php if (isset($_SESSION['loggedin'])) {
                    echo '<li class="hidden-xs"><button type="submit" form="logout-form" style="border:none;background-color:#FFF;">Logout</button></li>' ; 
                    }  ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- / header top  -->
    <!-- start Logout Form -->
    <form id="logout-form" style="display:none" action="logout.php" method="POST">
      <input type="hidden" name="logout_token" value="<?php echo $Login_token; ?>" />
      <input type="hidden" name="logout" value="logout" />
    </form>
    <!-- / Logout Form -->
    <!-- start header bottom  -->
    <div class="aa-header-bottom">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="aa-header-bottom-area">
              <!-- logo  -->
              <div class="aa-logo">
                <!-- Text based logo -->
                <a href="index.php">
                  <span class="fa fa-shopping-cart"></span>
                  <p>daily<strong>Shop</strong> <span>Your Shopping Partner</span></p>
                </a>
                <!-- img based logo -->
                <!-- <a href="index.php"><img src="assets/img/logo.jpg" alt="logo img"></a> -->
              </div>
              <!-- / logo  -->
               <!-- cart box -->
              <div class="aa-cartbox">
                <a class="aa-cart-link" href="#">
                  <span class="fa fa-shopping-basket"></span>
                  <span class="aa-cart-title">SHOPPING CART</span>
                  <span class="aa-cart-notify"> <?php echo $CartQty;  ?>  </span>
                </a>
                <div class="aa-cartbox-summary">
                  <ul>
                     <?php
                        if (isset($CartProducts)){
                            foreach ($CartProducts as $CartProduct) { 
                                $ProductDetails = $Product->GetProductsByID($CartProduct['pid']);
                                ?>
                        <li>
                          <a class="aa-cartbox-img" href="#"><img src="assets/img/woman-small-2.jpg" alt="img"></a>
                          <div class="aa-cartbox-info">
                            <h4><a href="#"><?php echo $ProductDetails['product_name']; ?></a></h4>
                            <p><?php echo $CartProduct['qty']; ?> x $<?php echo $ProductDetails['price'] ?></p>
                          </div>
                          <form id="RemoveFromCart" action="" method="POST">
                             <input type="hidden" name="pid" value="<?php echo  $ProductDetails['product_id'] ?>" />
                              <button type="submit" name="RemoveFromCart" class="aa-remove-product"><fa class="fa fa-close"></fa></button>
                           </form>
                        </li>
                         <?php    
                              }
                          }
                      ?>                  
                    <li>
                      <span class="aa-cartbox-total-title">
                        Total
                      </span>
                      <span class="aa-cartbox-total-price">
                        $ <?php echo $total; ?>
                      </span>
                    </li>
                  </ul>
                  <form method="POST" style="">
                  <button  type="submit" name="checkout" value="checkout" class="aa-cartbox-checkout aa-primary-btn">Proced to Checkout</button>
                </div>
              </div>
              <!-- / cart box -->
              <!-- search box -->
              <div class="aa-search-box">
                <form action="products.php" method="GET">
                  <input type="text" name="search"  placeholder="Search here ex. 'man' ">
                  <button type="submit" name="submit" value="submit"><span class="fa fa-search"></span></button>
                </form>
              </div>
              <!-- / search box -->             
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
          <form class="aa-login-form" action="register.php" method="POST" autocomplete="off">
            <label for="">Username or Email address<span>*</span></label>
            <input type="text" placeholder="email" name="email">
            <label for="">Password<span>*</span></label>
            <input type="password" placeholder="Password" name="password" autocomplete="off">
            <input type="hidden" name="login_token" value="<?php echo $Login_token; ?>"/>
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