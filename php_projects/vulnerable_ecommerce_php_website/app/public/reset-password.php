<?php   
include '../src/init.php';
include TPL_PATH.'header.inc.php';


if (!isset($_GET['token'])){

	// show an error message
    echo '<p class="error">Error: invalid Link Token not provided </p>';
   
    // return 405 http status code
    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    exit();
	
}

use Ecommerce\Controller\Auth As Auth;

$token = $_GET['token'];
$reset = new Auth\ResetContr();
$TokenCheck = $reset->ValidateResetToken($token);


if ($TokenCheck !== True){
	
	$email = False;
	echo $TokenCheck;
	// show an error message
    echo '<p class="error">Error: invalid Link </p>';
   
    // return 405 http status code
    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    exit();

}
else {
	
	 $email = $reset->GetEmailFromToken($token);
}

	    
if (isset($_POST['change'])){

	$NewPassword =$_POST['newpassword'] ;
	$ConfirmPassword = $_POST['confirmpassword']; 
	$ClientIp = $_SERVER['REMOTE_ADDR'];
	$ClientUseragent  = $_SERVER['HTTP_USER_AGENT'];
	
	$ReturnMsg = $reset->ResetUser($email,$NewPassword,$ConfirmPassword,$ClientIp,$ClientUseragent);

			
}

?>
<style type="text/css">
		.pass_show{position: relative} 
		.pass_show .ptxt { 

			position: absolute; 
			top: 50%; 
			right: 10px;
			z-index: 1; 
			color: #f36c01; 
			margin-top: -10px; 
			cursor: pointer; 
			transition: .3s ease all; 
		} 

		.pass_show .ptxt:hover{color: #333333;} 
	</style>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".pass_show").append("<span class="ptxt">Show</span>"");                                    
		});
		  

		$(document).on("click",".pass_show .ptxt", function(){ 

			$(this).text($(this).text() == "Show" ? "Hide" : "Show"); 
			$(this).prev().attr("type", function(index, attr){return attr == "password" ? "text" : "password"; }); 

		});  
	</script>

<div class="container">
	<div class="row">
		<div class="col-md-6">
		    <form method="POST" action="">
			 <label>New Password</label>
	            <div class="form-group pass_show"> 
	                <input type="password" name="newpassword"  class="form-control" placeholder="New Password"> 
	            </div> 
			       <label>Confirm Password</label>
	            <div class="form-group pass_show"> 
	                <input type="password"  name="confirmpassword" class="form-control" placeholder="Confirm Password"> 

	            </div> 
	            <button class="btn btn-success" type="submit" name="change" value="update" >Change  Password</button> 
            </form>
            
            <?php 
	            if (isset($ReturnMsg) && !empty($ReturnMsg)){
	                echo $ReturnMsg;
	              }
             ?>
             
		</div>  
	</div>
</div>


<?php include TPL_PATH.'footer.inc.php';  ?>

