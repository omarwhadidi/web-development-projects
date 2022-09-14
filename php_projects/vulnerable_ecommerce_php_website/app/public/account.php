<?php   
include '../src/init.php';
include TPL_PATH.'header.inc.php';
include TPL_PATH.'navbar.inc.php';

use Ecommerce\Controller\User As User;
// ----------------------------------- Session Validation --------------------------------------


$Auth->ValidateUserSession();

if(isset($_SESSION['loggedin']) && !isset($_COOKIE['usersession']) ){
  $Auth->LimitSessionDuration();
}

$Auth->ValidateCSRFTokenSession();

$token = $_SESSION['csrf_token'];

//$logouttoken = $_SESSION['logout_token']; 

// ----------------------------------- Session Validation --------------------------------------


if (isset($_POST['update'])){


   // CSRF Mitigation 

   if(isset($_POST['csrftoken']) && $_POST['csrftoken'] == $_SESSION['csrf_token']) {


      $Gender = (isset($_POST['gender']))  ? $_POST['gender'] : '' ; 
      $MFA = (isset($_POST['mfa']))  ? $_POST['mfa'] : '' ; 


      $Name             = $_POST['name'];
      $Username         = $_POST['username'];
      $Password         = $_POST['password'];
      $ConfirmPassword  = $_POST['password2'];
      $UserPic          = $_FILES['userpic'];
      $Client_ip        = $_SERVER['REMOTE_ADDR'];
      $useragent        = $_SERVER['HTTP_USER_AGENT'];

     
      $SignUp = new User\UpdateContr($UserSession,$Name,$Username,$Password,$ConfirmPassword,$Gender,$MFA,$UserPic,$Client_ip,$useragent);
     
      $msg = $SignUp->UpdateUser();
      

      
  }
  else {

      // show an error message
      echo  'Error: invalid Link ';
      
      // return 405 http status code
      header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
      die();
  }

}


    $UserData = $Customer->GetUserDetails($UserSession);
    
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
              <div class="col-md-4">
                <div class="aa-myaccount-login">
                  <h4>Update User Profile Pic</h4>
                  <div class="text-center">
                    <h2>Welcome <?php echo $UserSession; // Self XSS ?></h2>
                    <?php $Userpic = (!empty($UserData['userpic'])) ?  $UserData['userpic'] :  'https://via.placeholder.com/100'; 
                    	// XSS via  File Upload Filename escape_output($UserData['userpic']);
                    ?>
                    <img src="<?php echo $Userpic; ?>" style="max-width:250px;max-height:350px" class="avatar " alt="avatar">
                    <h6><label>Upload a different photo...</label></h6>   
                    <input type="file"  name="userpic" form="updateform">
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="aa-myaccount-register">                 
                 <h4>Update User info</h4>
                 <form action="account.php"  method="POST" enctype='multipart/form-data' id="updateform"class="aa-login-form">
                    <label for="">Update Your Name<span> *</span></label>
                    <input type="text" name="name" placeholder="Full Name" value="<?php echo escape_output($UserData['name']); ?>">
                    <label for="">Update Username<span> *</span></label>
                    <input type="text" name="username"  />
                    <label for="">Update Password<span> *</span></label>
                    <input type="password" name="password" placeholder="Password">
                    <label for="">Confirm Password<span> *</span></label>
                    <input type="password" name="password2" placeholder="Confirm Password">        
                    <div class="form-group">
                      <label>Gender </label></br>
                      <label>Male</label>
                      <input type="radio"  name="gender" value="Male" <?php echo ($UserData['gender'] == 'Male') ? 'checked' : False; ?> />
                      <label>Female</label>
                      <input type="radio"  name="gender" value="Female" <?php echo ($UserData['gender'] == 'Female') ? 'checked' : False ; ?> />
                  </div>
                  <div class="form-group">
                      <label>2 Factor Authentication </label></br>
                      <label>Enabled</label>
                      <input type="radio"  name="mfa" value="1" <?php echo ($UserData['mfa'] == 1) ? 'checked' : False; ?> />
                      <label>Disabled</label>
                      <input type="radio"  name="mfa" value="0" <?php echo ($UserData['mfa'] == 0) ? 'checked' : False ; ?> />
                  </div>
                    <input  type="hidden"  name="csrftoken" value="<?php echo $token; ?>">
                    <button type="submit" name="update" class="aa-browse-btn">Update</button>                    
                  </form>
                </div>
                 <div style="margin-top:80px;" ><?php if (isset($msg)){echo $msg;} ?> </div>
              </div>
            </div>          
         </div>
       </div>
     </div>
   </div>
 </section>
 <!-- / Cart view section -->

<?php  include TPL_PATH.'footer.inc.php';  ?>
