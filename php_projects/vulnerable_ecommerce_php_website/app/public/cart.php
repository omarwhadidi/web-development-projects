<?php
include '../src/init.php';
include TPL_PATH.'header.inc.php';
include TPL_PATH.'navbar.inc.php';

?>
  

 
  <!-- catg header banner section -->
  <section id="aa-catg-head-banner">
   <img src="assets/img/fashion/fashion-header-bg-8.jpg" alt="fashion img">
   <div class="aa-catg-head-banner-area">
     <div class="container">
      <div class="aa-catg-head-banner-content">
        <h2>Cart Page</h2>
        <ol class="breadcrumb">
          <li><a href="index.php">Home</a></li>                   
          <li class="active">Cart</li>
        </ol>
      </div>
     </div>
   </div>
  </section>
  <!-- / catg header banner section -->

 <!-- Cart view section -->
 <section id="cart-view">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
         <div class="cart-view-area">
           <div class="cart-view-table">
             <form action="">
               <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th></th>
                        <th></th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $total = 0 ;
                          if (isset($CartProducts)){
     
                              foreach ($CartProducts as $CartProduct) { 
                                
                                  $ProductDetails = $Product->GetProductsByID($CartProduct['pid']);
                                  
                                  $total += $ProductDetails['price'] * $CartProduct['qty'];

                                  ?>
                                  <tr>
                                    <td>  
                                      <form  action="cart.php" method="POST">
                                        <input type="hidden" name="pid" value="<?php echo  $ProductDetails['product_id'] ?>" />
                                        <button type="submit" name="RemoveFromCart"><fa class="fa fa-close"></fa></button>
                                      </form>
                                    </td>
                                    <td><a href="#"><img src="assets/img/man/polo-shirt-1.png" alt="img"></a></td>
                                    <td><a class="aa-cart-title" href="product.php?id=<?php echo $ProductDetails['product_id']; ?>"><?php echo $ProductDetails['product_name']; ?></a></td>
                                    <td>$ <?php echo $ProductDetails['price'] ?></td>
                                    <td><?php echo $CartProduct['qty']; ?></td>
                                    <td>$<?php echo $ProductDetails['price'] * $CartProduct['qty']; ?></td>
                                  </tr>
                      <?php 
                                  
                              }
                          }
                      ?>
                      <tr>
                        <td colspan="6" class="aa-cart-view-bottom">
                          <div class="aa-cart-coupon">
                            <form method="POST" >
                              <input class="aa-coupon-code" type="text" name="coupon" placeholder="Coupon">
                              <input class="aa-cart-view-btn" type="submit" name="ApplyCoupon" value="Apply Coupon">
                              <?php if (isset($CouponError)){echo '<div class= "alert alert-danger" style="margin-top:80px;" >'.$CouponError.'</div>';} ?>
                            </form>
                          </div>
                          <form method="POST">
                              <input class="aa-cart-view-btn" type="submit" name="EmptyCart" value="Empty Cart">
                            </form>
                          <form method="POST">
                            <input class="aa-cart-view-btn" type="submit" name="UpdateCart" value="Update Cart">
                          </form>
                        </td>
                      </tr>
                      </tbody>
                  </table>
                </div>
             </form>
             <!-- Cart Total view -->
             <div class="cart-view-total">
               <h4>Cart Totals</h4>
               <table class="aa-totals-table">
                 <tbody>
                   <tr>
                     <th>Subtotal</th>
                     <td>$<?php echo $total; ?></td>
                   </tr>
                   <tr>
                     <th>Total</th>
                     <td><?php if (isset($discount)){
                        echo '<p style="color:red;">$'.$total = $total - $total * $discount.'</p>';
                        } 
                        else {
                          echo '$'.$total; 
                        }?>
                      </td>
                   </tr>
                 </tbody>
               </table>
                <form method="POST" style="margin:10px 40px 20px;">
                  <button  type="submit" name="checkout" value="checkout" class="aa-cart-view-btn">Proced to Checkout</button>
               </form>
             </div>
              <?php if (isset($msg)){echo '<div class= "alert alert-danger" style="margin-top:80px;" >'.$msg.'</div>';} ?>
           </div>
         </div>
       </div>
     </div>
   </div>
 </section>
 <!-- / Cart view section -->


<?php include TPL_PATH.'footer.inc.php'; ?>