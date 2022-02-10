<head>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!------ Include the above in your HEAD tag ---------->
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
			$('.pass_show').append('<span class="ptxt">Show</span>');  
		});
		  

		$(document).on('click','.pass_show .ptxt', function(){ 

			$(this).text($(this).text() == "Show" ? "Hide" : "Show"); 
			$(this).prev().attr('type', function(index, attr){return attr == 'password' ? 'text' : 'password'; }); 

		});  
	</script>
</head>



<?php 
	include '../classes/dbh.classes.php';
	include '../classes/model/reset.classes.php';
	include '../classes/controller/reset-contr.classes.php';

	if (isset($_GET['token'])){

		$token = $_GET['token'];


		$reset = new ResetContr();
	    $email = $reset->ValidateUser($token);

	    if($email){

	    	echo '<body>
					<div class="container">
						<div class="row">
							<div class="col-sm-4">
							    <form method="POST" action="">
								 <label>New Password</label>
						            <div class="form-group pass_show"> 
						                <input type="password" name="pass"  class="form-control" placeholder="New Password"> 
						            </div> 
								       <label>Confirm Password</label>
						            <div class="form-group pass_show"> 
						                <input type="password"  name="pass2" class="form-control" placeholder="Confirm Password"> 

						            </div> 
						            <button class="btn btn-success" type="submit" name="change" value="update" >Change  Password</button> 
					            </form>
							</div>  
						</div>
					</div>
				</body>';

				if (isset($_POST['change'])){

					$newpassword =$_POST['pass'] ;
					$newpassword2 = $_POST['pass2']; 
					

					$reset->SetEmail($email);

					echo $reset->ResetUser($newpassword,$newpassword2);
				    
					
				}
	    }
	    else {

	    	// show an error message
		    echo '<p class="error">Error: invalid Link </p>';
		   
		    // return 405 http status code
		    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
	    }



	}
	else {

		// show an error message
	    echo '<p class="error">Error: invalid Link </p>';
	   
	    // return 405 http status code
	    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
	}

?>