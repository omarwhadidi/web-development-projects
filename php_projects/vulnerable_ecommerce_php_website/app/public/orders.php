<?php   
    include '../src/init.php';
    include TPL_PATH.'header.inc.php';
    include TPL_PATH.'navbar.inc.php';


// ----------------------------------- Session Validation --------------------------------------


$Auth->ValidateUserSession();

if(isset($_SESSION['loggedin']) && !isset($_COOKIE['usersession']) ){
  $Auth->LimitSessionDuration();
}

$Auth->ValidateCSRFTokenSession();


// ----------------------------------- Session Validation --------------------------------------

    $UserData = $Customer->GetUserDetails($UserSession);

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

 <!-- order view section -->
<section id="aa-myaccount">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
        <div class="aa-myaccount-area">         
            <div class="row">
              <div class="col-md-4">
                <div class="aa-myaccount-login">
                  <h4> User Profile Pic</h4>
                  <div class="text-center">
                    <?php $Userpic = (!empty($UserData['userpic'])) ?  $UserData['userpic'] :  'https://via.placeholder.com/100'; ?>
                    <img src="<?php echo $Userpic; ?>" style="max-width:250px;max-height:350px" class="avatar " alt="avatar">
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="aa-myaccount-register">                 
                 <h4> User Orders History </h4>
                    <table class="styled-table">
                      <thead>
                        <tr>
                          <td>
                            Order Id 
                          </td>
                          <td>
                            Products
                          </td>
                          <td>
                            Shipping Address
                          </td>
                          <td>
                            Amount Paid
                          </td>
                        </tr>
                      </thead>
                      <tbody>
                        
                      <?php 

                        $orders = $Customer->ReturnUserOrders($UserSession);

                        foreach ($orders as $order) {
                          
                          $UserProducts = json_decode($order['products'] , true);

                          ?>

                            <tr>
                              <td>
                               <a href="userorder.php?id=<?php echo escape_output($order['order_id']); ?>" > <?php echo escape_output($order['order_id']); ?> </a>
                              </td>
                              <td>

                                <?php 
                                    foreach ($UserProducts as $UserProduct) {
                                      echo escape_output($UserProduct['name']);
                                    }
                                    ?>
                              </td>
                              <td>
                                <?php echo escape_output($order['address']); ?>
                              </td>
                              <td>
                                <?php echo escape_output($order['paid_amount']) ?>
                              </td>
                            </tr>
                    
                        <?php } ?>

                      </tbody>
                    </table>
                </div>

              </div>
            </div>          
         </div>
       </div>
     </div>
   </div>
 </section>
 <!-- / order view section -->

<?php    include TPL_PATH.'footer.inc.php'; ?>