<?php   
include '../src/init.php';
include TPL_PATH.'header.inc.php';

if (!isset($_SESSION['mfa'])){

  header("Location: index.php");
  exit();
}



$User = new LoginContr();

if (isset($_POST['Login']) ){

  $username = $_SESSION['username'];
  $code = $_POST['code'];
  $msg = $User->MFALogin($username,$code);
}
?>

<!-- Cart view section -->
 <section id="aa-myaccount">
   <div class="container">
     <div class="row">
      <div class="col-md-12">
        <div class="aa-myaccount-area">         
          <div class="row">
              <div class="col-md-6">
                <div class="aa-myaccount-register">                 
                 <h4>2 Factor Authentication</h4>
                 <form action="<?php echo $_SERVER['PHP_SELF'];?>"  method="POST" class="aa-login-form" autocomplete="off">
                    <label for=""><span>2 FA Code</span></label>
                    <input type="text" name="code" placeholder="6 Digits Code" > 
                    
                    <?php if (isset($msg)){echo '<div class="alert alert-danger">'.$msg.'</div>';} ?>
                     
                    <button type="submit" name="Login" class="aa-browse-btn">Login</button>
                  </form>
                </div>
              </div>
          </div> 
        </div>
       </div>
    </div>
   </div>
 </section>
 <!-- / Cart view section -->

<?php include TPL_PATH.'footer.inc.php';  ?>