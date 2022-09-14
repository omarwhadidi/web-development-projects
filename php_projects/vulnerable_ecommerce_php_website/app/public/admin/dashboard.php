<?php   
include 'init.php';
include 'includes/templates/header.inc.php';



if (isset($_POST['activate'])){

    $usern = $_POST['activate'];
    $Admin->ActivateAccount($usern);

}

if (isset($_POST['deactivate'])){

    $usern = $_POST['deactivate'];
    $Admin->DeactivateAccount($usern);

}

if (isset($_POST['makemoderator'])){

    $usern = $_POST['makemoderator'];
    $Admin->UpgradeAccount($usern);

}

if (isset($_POST['makeuser'])){

    $usern = $_POST['makeuser'];
    $Admin->DowngradeAccount($usern);

}

if (isset($_POST['AddProduct'])){

  $ProductName = $_POST['name'];
  $SellerName = $_POST['seller'];
  $Category = $_POST['category'];
  $ProductStatus = $_POST['status'];
  $ProductQuantity = $_POST['quantity'];
  $ProductPrice = $_POST['price'];
  $ProductDetails = $_POST['product_details'];
  $Productimage = $_FILES['product_image'];


  $ProductResult = $Admin->AddProduct($ProductName,$Category,$ProductDetails,$ProductQuantity,$ProductPrice,$SellerName,$Productimage,$ProductStatus);

  if ($ProductResult !== True){
    $ProductError = $ProductResult;
  }
  else {
    $ProductMsg = 'Product Inserted Sucessfully';
  }

}

?>



<style type="text/css">
  .styled-table {
    border-collapse: collapse;
    margin: 25px 0;
    font-size: 0.9em;
    font-family: sans-serif;
    min-width: 400px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    width: 100%;
}
.styled-table thead tr {
    background-color: #009879;
    color: #ffffff;
    text-align: left;
}
.styled-table th,
.styled-table td {
    padding: 12px 15px;
}

.styled-table td a {
   text-decoration: underline;
   color: blue;
}

.styled-table tbody tr {
    border-bottom: 1px solid #dddddd;
}

.styled-table tbody tr:nth-of-type(even) {
    background-color: #f3f3f3;
}

.styled-table tbody tr:last-of-type {
    border-bottom: 2px solid #009879;
}
</style>
  <!-- catg header banner section -->
  <section id="aa-catg-head-banner">
    <img src="../assets/img/fashion/fashion-header-bg-8.jpg" alt="fashion img">
    <div class="aa-catg-head-banner-area">
     <div class="container">
      <div class="aa-catg-head-banner-content">
        <h2>Dashboard Page</h2>
        <ol class="breadcrumb">
          <li><a href="index.php">Home</a></li>                   
          <li class="active">Dashboard</li>
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
        <!--   Users Details section -->

          <?php  
            $action = array('products','orders','feedbacks');
            
            if ( (isset($_GET['action']) && $_GET['action'] == 'users') || (isset($_GET['action']) && !in_array($_GET['action'], $action )) || (!isset($_GET['action'])) ){  ?>
 
           <h3>The list of users  and their Details :</h3>
           <table class="styled-table" >
              <tr>
                  <th align='left'>user ID </th><th>UserName </th><th> Full Name </th><th>email </th><th>Gender </th><th>CLient IP </th><th>Regstatus </th><th>Permissions </th><th>Change Status </th><th>Change permissions </th>
              </tr>
             <?php  

                $users = $Admin->GetAllUsers();

               foreach ($users as $user) {

                  $name = $user["username"];
                  $email = $Admin->GetEmailByUsername($name);
                  $userpermissions = $Admin->GetUserPermissions($email);
                  //$userpermissions = (new AdminContr)->GetUserPermissions($name); // you must define a new object inside an array otherwise you will get an error             
              
                  echo "<tr>
                      <td>".escape_output($user["id"])."</td>
                      <td>".escape_output($user["username"])."</td>
                      <td>".escape_output($user["name"])."</td>
                      <td>".escape_output($user["email"])."</td>
                      <td>".escape_output($user["gender"])."</td>
                      <td>".escape_output($user["client_ip"])."</td>
                      <td>".escape_output($user["Account_status"])."</td>
                      <td>".escape_output($userpermissions["group_name"])."</td>
                      <td><form method='POST' ><input type='hidden' name='deactivate' value='$name'/>
                             <button type='submit' class='alert alert-danger'>Deactivate Account</button> 
                          </form>
                          <form method='POST' ><input type='hidden' name='activate' value='$name'/>
                              <button type='submit' class='alert alert-success' style='width:100%'>Activate Account</button> 
                          </form></td>
                      <td><form method='POST' ><input type='hidden' name='makeuser' value='$email'/>
                             <button type='submit' class='alert alert-danger'>Downgrade to User</button> 
                          </form>
                          <form method='POST' ><input type='hidden' name='makemoderator' value='$email'/>
                              <button type='submit' class='alert alert-success' style='width:100%'>Make Moderator</button> 
                          </form></td>

                      </tr>";
               }

              ?>  

            </table>
            <hr>
          <?php } ?>
        <!-- / Users Details section -->
        <!--   Orders Details section -->
          <?php  if (isset($_GET['action']) && $_GET['action'] == 'orders' ){  ?>
 
           <h3>The list of Orders and their Details :</h3>
           <table class="styled-table" >
              <tr>
                  <th align='left'>Order ID </th><th>Name </th><th> Username </th><th>Email </th><th>Phone Number </th><th>Address </th><th>Products </th><th>Amount Paid</th><th>Payment Method</th><th>Order date </th>
              </tr>
             <?php  

              $orders = $Admin->GetAllOrders();

              foreach ($orders as $order) {

                $ProductsDetails =  json_decode($order["products"],True);
                ?>
                  <tr>
                          <td><?php echo escape_output($order["order_id"]); ?></td>
                          <td><?php echo escape_output($order["name"]); ?></td>
                          <td><?php echo escape_output($order["username"]); ?></td>
                          <td><?php echo escape_output($order["email"]); ?></td>
                          <td><?php echo escape_output($order["phone"]); ?></td>
                          <td><?php echo escape_output($order["address"]); ?></td>
                          <td style="width:15%"><?php  foreach ($ProductsDetails as $ProductDetails) {
                            echo escape_output($ProductDetails['name']) .' * '. escape_output($ProductDetails['qty']) .'<br>';
                          } ?></td>
                          <td><?php echo escape_output($order["paid_amount"]); ?></td>
                          <td><?php echo escape_output($order["payment_mode"]); ?></td>
                          <td><?php echo escape_output($order["order_date"]); ?></td>
                        </tr>";
               <?php } ?>  

            </table>
            <hr>
          <?php } ?>
        <!-- / Orders Details section -->
        <!--   Products Details section -->
          <?php  if (isset($_GET['action']) && $_GET['action'] == 'products' ){  ?>
 
           <h3>The list of Products and their Details :</h3>
           <table class="styled-table" >
              <tr>
                  <th align='left'>Product ID </th><th>Name </th><th> Category </th><th>Quantity </th><th>Price </th><th>Seller Name </th><th>Status </th><th>Added Date</th>
              </tr>
             <?php  

                $products = $Admin->GetAllProducts();

                foreach ($products as $product) {

                  $ProductDetails =  json_decode($product["product_name"]);
                  print_r($ProductDetails);
                  //$userpermissions = (new AdminContr)->GetUserPermissions($name); // you must define a new object inside an array otherwise you will get an error             
              
                  echo "<tr>
                          <td>".escape_output($product["product_id"])."</td>
                          <td>".escape_output($product["product_name"])."</td>
                          <td>".escape_output($product["category"])."</td>
                          <td>".escape_output($product["quantity"])."</td>
                          <td>".escape_output($product["price"])."</td>
                          <td>".escape_output($product["seller_name"])."</td>
                          <td>".escape_output($product["product_status"])."</td>
                          <td>".escape_output($product["added_date"])."</td>
                        </tr>";

                }

            ?>  

            </table>
            <hr>

          <h3>Insert Product:</h3>
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="aa-contact-address">
             <div class="row">
               <div class="col-md-8">
                 <div class="aa-contact-address-left">
                   <form class="comments-form contact-form" method="POST">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">                        
                          <input type="text" placeholder="Product Name" class="form-control" name="name">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">                        
                          <input type="text" placeholder="Seller Name" class="form-control" name="seller">
                        </div>
                       </div>   
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">                        
                          <input type="text" placeholder="Category" class="form-control" name="category">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">                        
                          <input type="text" placeholder="Product Status" class="form-control" name="status">
                        </div>
                       </div>   
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">                        
                          <input type="text" placeholder="Product Price" class="form-control" name="price">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">                        
                          <input type="text" placeholder="Product Quatity" class="form-control" name="quantity">
                        </div>
                       </div>   
                    </div>                  
                    <div class="form-group">                        
                      <textarea class="form-control" rows="3" placeholder="Product Details" name="product_details"></textarea>
                    </div>
                    <button class="aa-secondary-btn" type="submit" name="AddProduct" >Add Product</button>
                  <?php if (isset($ProductError)){echo '<div class= "alert alert-danger" style="margin-top:80px;" >'.$ProductError.'</div>';} ?>
                  <?php if (isset($ProductMsg)){echo '<div class= "alert alert-success" style="margin-top:80px;" >'.$ProductMsg.'</div>';} ?>
                 </div>
               </div>
               <div class="col-md-4">
                 <div class="aa-contact-address-right">
                   <div>
                     <h4>Product Image</h4>
                     <p>Please Insert an image For the Product.</p>
                     <input type="file" name="product_image" >
                   </div>
                 </div>
               </div>
             </div>
           </div>
          </form>
       <?php } ?>
        <!-- / Products Details section -->
        <!--   Feedbacks Details section -->
          <?php  if (isset($_GET['action']) && $_GET['action'] == 'feedbacks' ){  ?>
 
           <h3>User Messages & Feedbacks :</h3>
           <table class="styled-table" >
              <tr>
                  <th align='left'> Number </th><th>Name </th><th> Email </th><th> Subject </th><th>Message</th>
              </tr>
             <?php  

                $Feedbacks = $Admin->GetUsersFeedbacks();

               foreach ($Feedbacks as $Feedback) {
           
                // Blind XSS 
                  echo "<tr>
                          <td>".escape_output($Feedback["id"])."</td>
                          <td>".escape_output($Feedback["name"])."</td>
                          <td>".escape_output($Feedback["email"])."</td>
                          <td>".$Feedback["subject"]."</td> 
                          <td>".escape_output($Feedback["message"])."</td>
                        </tr>";
               }

              ?>  

            </table>
            <hr>
          <?php } ?>
        <!-- / Feedbacks Details section -->
              </div>
            </div>          
         </div>
         </div>
        </div>
    </div>
 </section>
 <!-- / Cart view section -->

<?php    

include TPL_PATH.'footer.inc.php'; 


?>