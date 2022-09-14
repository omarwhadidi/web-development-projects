<?php   
  include '../src/init.php';
  include TPL_PATH.'header.inc.php';
  include TPL_PATH.'navbar.inc.php';

if(!isset($_SESSION['cart']) || empty($_SESSION['cart']) ){

  header("Location: index.php");
  exit();
}


$CartProducts = $_SESSION['cart'];
$total = 0;
$userproducts = array();

foreach ($CartProducts as $CartProduct) { 

    $userproduct = array();
    $pid = $CartProduct['pid'];   
    $ProductDetails = $Product->GetProductsByID($pid);

    $total += $ProductDetails['price'] * $CartProduct['qty'];

    $userproduct['pid'] = $ProductDetails['product_id'];    
    $userproduct['name'] = $ProductDetails['product_name'];    
    $userproduct['qty'] = $CartProduct['qty'];

    array_push($userproducts, $userproduct);
}


if (isset($_SESSION['discount'])){

  $AmountToPay = $total - $total * $_SESSION['discount'];

}
else {

  $AmountToPay = $total;

}

if (isset($_POST['PlaceOrder'])){

    $FirstName = $_POST['firstname'];
    $LastName = $_POST['lastname'];
    $Name = $FirstName . ' ' . $LastName;
    $Email = $_POST['email'];
    $Phone = $_POST['number'];
    $Address = $_POST['address'];
    $CreditCard = $_POST['creditcard'];

    //echo json_encode($userproducts);

   $CheckoutResult =  $Customer->Checkout($Name, $UserSession,$Email, $Phone , $Address, $CreditCard , json_encode($userproducts) , $AmountToPay);


    if ($CheckoutResult === True){

        if (isset($_SESSION['loggedin'])){

            header("Location: orders.php");
            exit();

        }
        else {

            header("Location: index.php");
            exit();
        }
    
    }

}

?>


 
  <!-- catg header banner section -->
  <section id="aa-catg-head-banner">
    <img src="assets/img/fashion/fashion-header-bg-8.jpg" alt="fashion img">
    <div class="aa-catg-head-banner-area">
     <div class="container">
      <div class="aa-catg-head-banner-content">
        <h2>Checkout Page</h2>
        <ol class="breadcrumb">
          <li><a href="index.php">Home</a></li>                   
          <li class="active">Checkout</li>
        </ol>
      </div>
     </div>
   </div>
  </section>
  <!-- / catg header banner section -->

 <!-- Cart view section -->
 <section id="checkout">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
        <div class="checkout-area">
          <form id="checkout" action="" method="POST">
            <div class="row">
              <div class="col-md-8">
                <div class="checkout-left">
                  <div class="panel-group" id="accordion">

                    <!-- Billing Details 
                    <div class="panel panel-default aa-checkout-billaddress">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                            Billing Details
                          </a>
                        </h4>
                      </div>
                      <div id="collapseThree" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="Credit Card*"></input>
                              </div>                             
                            </div>                            
                          </div>                                     
                        </div>
                      </div>
                    </div>
                     Shipping Address -->
                    <div class="panel panel-default aa-checkout-billaddress">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                            Shippping Address
                          </a>
                        </h4>
                      </div>
                      <div id="collapseFour" class="panel-collapse collapse">
                        <div class="panel-body">
                         <div class="row">
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="text" name="firstname" placeholder="First Name*" value="<?php echo isset($UserDetails) ?  escape_output($UserDetails['name']) : '' ;?>">
                              </div>                             
                            </div>
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="text" name="lastname" placeholder="Last Name*">
                              </div>
                            </div>
                          </div>   
                          <div class="row">
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="email" name="email" placeholder="Email Address*" Value="<?php echo isset($UserDetails) ?  escape_output($UserDetails['email']) : '' ;?>">
                              </div>                             
                            </div>
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="tel" name="number" placeholder="Phone*">
                              </div>
                            </div>
                          </div> 
                          <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <textarea cols="8" rows="3" name="address" placeholder="Address*"></textarea>
                                
                              </div>                             
                            </div>                            
                          </div>  
                          <!-- 
                          <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <select>
                                  <option value="0">Select Your Country</option>
                                  <option value="1">Australia</option>
                                  <option value="2">Afganistan</option>
                                  <option value="3">Bangladesh</option>
                                  <option value="4">Belgium</option>
                                  <option value="5">Brazil</option>
                                  <option value="6">Canada</option>
                                  <option value="7">China</option>
                                  <option value="8">Denmark</option>
                                  <option value="9">Egypt</option>
                                  <option value="10">India</option>
                                  <option value="11">Iran</option>
                                  <option value="12">Israel</option>
                                  <option value="13">Mexico</option>
                                  <option value="14">UAE</option>
                                  <option value="15">UK</option>
                                  <option value="16">USA</option>
                                </select>
                              </div>                             
                            </div>                            
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="Appartment, Suite etc.">
                              </div>                             
                            </div>
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="City / Town*">
                              </div>
                            </div>
                          </div>   
                          <div class="row">
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="District*">
                              </div>                             
                            </div>
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="Postcode / ZIP*">
                              </div>
                            </div>
                          </div> 
                          <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <textarea cols="8" rows="3">Special Notes</textarea>
                              </div>                             
                            </div>                            
                          </div> 
                          -->             
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php if (isset($CheckoutResult)){echo '<div class="alert Alert-danger">'.$CheckoutResult.'</div>';} ?>
                </div>
              </div>
              <div class="col-md-4">
                <div class="checkout-right">
                  <h4>Order Summary</h4>
                  <div class="aa-order-summary-area">
                    <table class="table table-responsive">
                      <thead>
                        <tr>
                          <th>Product</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        foreach ($CartProducts as $CartProduct) { 
                                
                                  $ProductDetails = $Product->GetProductsByID($CartProduct['pid']);
                                
                                echo "
                                  <tr>
                                    <td>".$ProductDetails['product_name']." <strong> x  ".$CartProduct['qty']."</strong></td>
                                    <td>$".$ProductDetails['price'] * $CartProduct['qty']."</td>
                                  </tr>
                            ";
                          }
                        ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>Subtotal</th>
                          <td>$<?php echo $total; ?></td>
                        </tr>
                         <tr>
                          <th>Tax</th>
                          <td>$0</td>
                        </tr>
                         <tr>
                          <th>Total</th>
                          <td style="color:red">$<?php echo $AmountToPay; ?>
                          </td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                  <h4>Payment Method</h4>
                  <div class="aa-payment-method">                    
                    <label for="cashdelivery"><input type="radio" id="cashdelivery" name="optionsRadios"> Cash on Delivery </label>
                    <label for="paypal"><input type="radio" id="paypal" name="optionsRadios" checked> Via Paypal </label>
                    <img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg" border="0" alt="PayPal Acceptance Mark"> 
                    <input type="text" name="creditcard" placeholder="1234123412341234" style="width: 100%">   
                    <input   type="submit" name="PlaceOrder" value="Place Order" class="aa-browse-btn">                
                  </div>
                </div>
              </div>
            </div>
          </form>
         </div>
       </div>
     </div>
   </div>
 </section>
 <!-- / Cart view section -->
    
 <?php    include TPL_PATH.'footer.inc.php';  ?>