<?php
ob_start();


require 'includes/core/config.php';
include 'classes/dbh.classes.php';
include 'classes/session.classes.php';
include 'classes/model/user.classes.php';
include 'classes/model/update.classes.php';
include 'classes/controller/user-contr.classes.php';
include 'classes/controller/update-contr.classes.php';



// ----------------------------------- Session Validation --------------------------------------

session_start();

$session = new Session();
$session->ValidateUserSession();
$session->ValidateLogoutTokenSession();
$session->LimitSessionDuration(); 

$username = $_SESSION['username'];
$logouttoken = $_SESSION['logout_token']; 

// ----------------------------------- Session Validation --------------------------------------



$user = new UserContr();
$userData = $user->GetUserInfo($username) ; 

$update = new UpdateContr();

if (!isset($_SESSION['csrf_token'])) {

    $gettoken = $update->PrintToken();
    $_SESSION['csrf_token'] = $gettoken;

}

$token = $_SESSION['csrf_token'];



if (isset($_POST['submit'])){


  // CSRF Mitigation 

   if(isset($_POST['csrftoken']) && $_POST['csrftoken'] == $_SESSION['csrf_token']) {


      
        $Firstname = $_POST['firstname'];
        $Lastname = $_POST['lastname'];
        $Email = $_POST['email'];
        $Password = $_POST['password'];
        $Password2 = $_POST['password2'];
        $FormToken = $_POST['csrftoken'];
        $ProfilePic = $_FILES["fileToUpload"];
        
        $update->SetUserData($Firstname,$Lastname,$Username,$Email,$Password,$Password2,$ProfilePic);
        
        $Results =  $update->UpdateUser();

        

    }
    else {

      // show an error message
      $Results =  'Error: invalid Link ';
      //die();
      // return 405 http status code
      //header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    }

    

}

include 'includes/templates/header.inc.php';
?>

<br>
<div class="container">
    <h1>Edit Profile</h1>
  	<hr>
	<div class="row">
      <!-- left column -->
      <div class="col-md-3">
        
          <div class="text-center">
            <img src="//placehold.it/100" class="avatar img-circle" alt="avatar">
            <h6>Upload a different photo...</h6>   
            <input type="file" class="form-control" name="fileToUpload" form="myform">
          </div>

      </div>
      
      <!-- edit form column -->
      <div class="col-md-9 personal-info">
        <div class="alert alert-info alert-dismissable">
          <a class="panel-close close" data-dismiss="alert">×</a> 
          <i class="fa fa-coffee"></i>
          <?php if (isset($Results)){echo $Results;}?>
        </div>
        <h3>Personal info</h3>
        
        <form method="POST" class="form-horizontal" id="myform" role="form" enctype="multipart/form-data" autocomplete="off">
          <div class="form-group">
            <label class="col-lg-3 control-label">First name:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" placeholder="First Name" name="firstname">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Last name:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" placeholder="Last Name" name="lastname">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Company:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" placeholder="Company">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Email:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" placeholder="Username@example.com" name="email">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Time Zone:</label>
            <div class="col-lg-8">
              <div class="ui-select">
                <select id="user_time_zone" class="form-control">
                  <option value="Hawaii">(GMT-10:00) Hawaii</option>
                  <option value="Alaska">(GMT-09:00) Alaska</option>
                  <option value="Pacific Time (US &amp; Canada)">(GMT-08:00) Pacific Time (US &amp; Canada)</option>
                  <option value="Arizona">(GMT-07:00) Arizona</option>
                  <option value="Mountain Time (US &amp; Canada)">(GMT-07:00) Mountain Time (US &amp; Canada)</option>
                  <option value="Central Time (US &amp; Canada)" selected="selected">(GMT-06:00) Central Time (US &amp; Canada)</option>
                  <option value="Eastern Time (US &amp; Canada)">(GMT-05:00) Eastern Time (US &amp; Canada)</option>
                  <option value="Indiana (East)">(GMT-05:00) Indiana (East)</option>
                </select>
              </div>
            </div>
          </div>
<!--           <div class="form-group">
            <label class="col-md-3 control-label">Username:</label>
            <div class="col-md-8">
              <input class="form-control" type="text" placeholder=" Username" name="username">
            </div>
          </div> -->
          <div class="form-group">
            <label class="col-md-3 control-label">Password:</label>
            <div class="col-md-8">
              <input class="form-control" type="password" autocomplete="new-password" placeholder="Password" name="password">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">Confirm password:</label>
            <div class="col-md-8">
              <input class="form-control" type="password" autocomplete="new-password" placeholder="Confirm Password" name="password2">
            </div>
          </div>
          <input  type="hidden"  name="csrftoken" value="<?php echo $token; ?>">
          <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8">
              <input type="submit" name="submit" class="btn btn-primary" value="Save Changes">
              <span></span>
             <!-- <input type="reset" class="btn btn-default" value="Cancel"> -->
            </div>
          </div>
        </form>
      </div>
  </div>
</div>
<hr>
<?php
include 'includes/templates/footer.inc.php';

?>

