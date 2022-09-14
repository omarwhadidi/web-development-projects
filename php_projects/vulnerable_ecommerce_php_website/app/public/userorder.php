<?php 
require '../src/init.php';
include TPL_PATH.'header.inc.php';
include TPL_PATH.'navbar.inc.php';

// ----------------------------------- Session Validation --------------------------------------


$Auth->ValidateUserSession();

if(isset($_SESSION['loggedin']) && !isset($_COOKIE['usersession']) ){
  $Auth->LimitSessionDuration();
}

$Auth->ValidateCSRFTokenSession();


// ----------------------------------- Session Validation --------------------------------------


if (!isset($_GET['id'])){

  header("Location: index.php");
  exit();
}

$OrderId =  $_GET['id'];
$OrderDetails = $Customer->CheckUserOrder($OrderId,$UserSession);

if ($OrderDetails === False){

    header("HTTP/1.1 401 Unauthorized");
    exit();
  
}


?>
 
 
  <!-- catg header banner section -->
  <section id="aa-catg-head-banner">
   <img src="assets/img/fashion/fashion-header-bg-8.jpg" alt="fashion img">
   <div class="aa-catg-head-banner-area">
     <div class="container">
      <div class="aa-catg-head-banner-content">
        <h2>T-Shirt</h2>
        <ol class="breadcrumb">
          <li><a href="index.php">Home</a></li>         
          <li><a href="#">Product</a></li>
          <li class="active">T-shirt</li>
        </ol>
      </div>
     </div>
   </div>
  </section>
  <!-- / catg header banner section -->

  <!-- product category -->
  <section id="aa-product-details">
    <div class="container" style="margin-bottom: 100px">
      <div class="row">
        <div class="col-md-12">
          <h1 style="text-align: center; font-size: 42px;">Order Nb <?php echo escape_output($OrderDetails['order_id']) ;?>#</h1>
          <div class="aa-product-details-area">
            <div class="aa-product-details-content">
              <div class="row" style="margin-left: 20%">
                <!-- Modal view slider -->
                <div class="col-md-5">                              
                        <h3>Order ID: <?php echo escape_output($OrderDetails['order_id']) ;?></h3>
                        <h3>Order Date: <?php echo escape_output($OrderDetails['order_date']) ;?></h3>
                        <h3>Shipping Address: <?php echo escape_output($OrderDetails['address']) ;?></h3>
                        <h3>Phone Number: <?php echo escape_output($OrderDetails['phone']) ;?></h3>

                </div>
                <!-- Modal view content -->
                <div class="col-md-5">
                  <div class="aa-product-view-content">
                    <h3>Full Name: <?php echo escape_output($OrderDetails['name']) ;?></h3>
                    <div class="aa-price-block">
                      <h3 class="aa-product-view-price">Amont Paid $<?php echo escape_output($OrderDetails['paid_amount']) ;?></h3>
                      <h3 class="aa-product-avilability"><emp style="font-size: 24px">Payment Method:</emp> <span><?php echo escape_output($OrderDetails['payment_mode']) ;?></span></h3>
                    </div>
                    <p><emp style="font-size: 24px">Products:</emp></p> <ul style=""><?php 
                        $UserProducts = json_decode($OrderDetails['products'],true) ;

                        foreach ($UserProducts as $UserProduct) {
                          echo '<li>'.escape_output($UserProduct['name']) .' * '.escape_output($UserProduct['qty']).'<li>';
                        }
                        ?></ul>

                    </div>
 
                  </div>
                </div>
                <div style="text-align: center;">
                  <form action="orderpdf.php" method="POST">
                    <input type="hidden" name="order_id" value="<?php echo $OrderId; ?>">
                    <button type="submit" name="Generateorder">Generate Receipet PDF</button>
                  </form>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / product category -->

 <?php include TPL_PATH.'footer.inc.php' ;?>