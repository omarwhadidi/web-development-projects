<?php 
@ob_start();
session_start();
session_regenerate_id(); //to prevent session fixation
	 if(!empty($_COOKIE['fusername'])) 
	 	{ 
	 		$_SESSION['username']==$_COOKIE['username'];
	 		header('location:home.php');} 
	 
?>


<html>
	<head lang="en-us">
		<title>social</title>
		                              <!--META TAGS -->
		<meta charset="utf-8" />
		<meta name="description" content="Connect with friends and pentesters and other people you know. Share photos and videos, send messages and get updates." />
		<meta name="keyword" content="flagx , flag , social , network , social network , connect , " />
		<meta name="author" content="OMar El Hadidi"  />
		<meta name="robots" content="index,follow" />
		<meta name="viewport" content="width=device-width,initial-scale=1.0" />


										<!--LNIK TAGS -->
		<link rel="stylesheet" href="css/normalize.css" /> 
		<link rel="stylesheet" href ="css/bootstrap.min.css" />
		<link rel="stylesheet" href ="fonts/all.css" />				<!--FONTAWESOME FILE -->
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Sofia' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="css/main.css" />
										<!--fav icons  -->
		<link rel="icon" href="images/favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
		<link rel="apple-touch-icon" href="">  						<!--APPLE FAVICONS -->



	</head>
	<body>
		<header>

			<h1 class="logo">flagx community</h1>

		</header>
		<main>
			<section>
				
				<i id="pic" class="fas fa-globe"></i>
				<div class="kalam">
				<h2 class="typed"></h2>
				</div>
			</section>
			<aside>
				<div class="content"> 
					<div id="pop" class="popup_error"></div>
					<h2>login to your account</h2>
					<form class="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="validateuser">
						<div class="cont">
							<div class="log_icon"> <i class="fa fa-user" aria-hidden="true"></i></div>
							<div class="error"> <i id="jsuser" class="fas fa-asterisk " aria-hidden="true"></i></div>

							<input type="text" name="username" id="icon_name" class='vlog' placeholder="username"  autocomplete="off" required="required" />
						</div>
						<div class="cont">
							<div class="pass_icon"> <i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
							<div class="errorp"> <i id="jspass" class="fas fa-asterisk " aria-hidden="true"></i></div>
							<input type="password" name="password" id="icon_pass" placeholder="password" required="required" />
						</div>
						<div class="remember">
							<input type="checkbox" id="rem" name="remember_me" value="True" />
							<label for="rem">remember me</span>

						</div>
						
						<input type="submit" class="lg" name="login" value="login" id='loguser' />
						<a class="redirect" href="register.php" >register</a>

					</form>
					<p><a href="forgetpassword.php" target="_self">forgot your password ?</a></p>
				</div>

			</aside>
		</main>
		

			<script src="js/all.js" ></script>						<!--fontawesome js file -->
			<script src="js/jquery.js"></script>
			<script src="js/typed.min.js"></script>
			<script src="js/main.js" ></script>
			<script >

				document.getElementById("validateuser").addEventListener("submit", function(event){
				  
				  	var uname = document.getElementById("icon_name").value;
				  	var upass = document.getElementById("icon_pass").value;
				  	
				  	var count=0;
					
					if (uname==''){

						document.getElementById('jsuser').style.color='#E4324C';
						count++;
					}
					
					if (upass==''){

						document.getElementById('jspass').style.color='#E4324C';
						count++;
					}
					
					if (count >0){
						event.preventDefault();
					}
					

				});


			
				
				var typed = new Typed('.typed', {
				  strings: ["welcome pentesters ..." ],
				  loop:true,
				  typeSpeed: 100,
				  backSpeed:100,
				  backDelay:2000
				});
			</script>
	</body>



</html>

<?php


if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['login'])){



	 


	//initializing input
	$user='';
	$password='';
	
	$error=array();
	$count=0;

	//validating input

	function test_input($data){
		$data=trim($data);
		$data=stripslashes($data);
		$data=htmlspecialchars($data);
			return $data;

	}

	if (!empty($_POST['username'])){
		$user=test_input($_POST['username']);
		

	}
	else {
		 
		 $count++;
		 echo "<script>document.getElementById('jsuser').style.color='#E4324C';</script>";
	}

	if (!empty($_POST['password'])){
		$password=test_input($_POST['password']);
		
	}
	else {
		
		 $count++;
		 echo "<script>document.getElementById('jspass').style.color='#E4324C';</script>";
	}
	if (!empty($_POST["remember_me"])){
		$remember=test_input($_POST["remember_me"]);
		

	}
	else {
		 $remember='';
		 
	}

	//showing errors

	 if ($count>0){
	 		exit();
	 	 


	}
	else {
		require 'db_connection.php' ;

		$id="";
		$sql="SELECT username ,password, user_id FROM users WHERE username= ?";

			$stmt =$conn->prepare($sql);

			//bind variables
			$stmt->bind_param("s",$param_username);
			

			//set params
			$param_username=$user;

			
			if ($stmt->execute()){

				//store result
				$stmt->store_result();

				//check if username exists
				if($stmt->num_rows >0){
					

					 $stmt->bind_result($user,$passwordenc,$id);
					if($stmt->fetch()){
						

						if (md5($password) == $passwordenc){
							
							$_SESSION["username"] =$user;
							$_SESSION["id"] = $id;

							if($remember=='1' || $remember=='True')
			                    {

			                    $hour = time() + 3600 * 24 * 30;
			                    	setcookie('fusername', $user, $hour , '/');
			                         setcookie('fpassword', $password, $hour ,'/');
			                    }

							//header("location:home.php"); not working headers already sent

							echo "<script>window.location.href='home.php';</script>";
					
						}
						else {
							 echo  " <script> document.getElementById('pop').style.visibility='visible';
							 					document.getElementById('pop').innerHTML +='wrong password'
							 		 </script>";
										
						}
					}
				}

				else {
					 echo  " <script> document.getElementById('pop').style.visibility='visible';
							 		 document.getElementById('pop').innerHTML +='wrong username'
							</script>";
										
				}
			}
			
			
		
			

			




			//close connection
					$stmt->free_result();
		 			$stmt->close();
		 			$conn->close();




	}//end slashe of error

} //end slash of submit 
?>