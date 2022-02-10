<html>
	<head>
		<title>FlagX</title>
								<!--meta tags-->
		<meta charset="utf-8" />
		<meta name="description" content="Connect with friends and pentesters and other people you know. Share photos and videos, send messages and get updates." />
		<meta name="keyword" content="flagx , flag , social , network , social network , connect , " />
		<meta name="author" content="Omar El Hadidi"  />
		<meta name="robots" content="noindex,nofollow" />
		<meta name="viewport" content="width=device-width,initial-scale=1.0" />

		<link rel="icon" href="images/favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
		
		<link rel="apple-touch-icon" href="favicon.ico">  				<!--APPLE FAVICONS -->

								<!--page style-->
		<style>
			
			fieldset {
				border:2px solid #E44D3A !important;
				height:450px;
			}
			legend {
				background-color:#E44D3A;
				color:#fff;
				width:150px;
				padding:15px 0 15px 20px;

			}
			div {
				margin:2%;
			}
			form input[type="email"] {

				width: 20%;
			    height: 35px;
			    margin-left: 2%;
			    padding-left: 10px;
			
			}
			form  input[type="submit"]{
				margin-top:20px;
				width:15%;
				height:40px;
				margin-left:1%;
				padding-left:10px;
				background-color:#E44D3A;
				color:#fff; 
				outline:0px;
				border:0px;
				border-radius: 8px;
				margin-top: 20px;
				cursor:pointer;

			}
			
		@media (max-width:767px) {    /* for mobiles */		

			fieldset {
				
			}
			legend {
				background-color:#E44D3A;
				color:#fff;
				width:150px;
				padding:15px 0 15px 20px;

			}
			form input[type="email"] {

				width: 58%;
			    height: 35px;
			    margin-left: 2%;
			    padding-left: 10px;
			
			}
			form input[type="submit"]{
				margin-top:20px;
				width:35% ;
				height:40px;
				margin-left:2%;
				padding-left:10px;
				background-color:#E44D3A;
				color:#fff; 
				outline:0px;
				border:0px;
				border-radius: 8px;
				cursor:pointer;
			}

		}
		</style>
		
	</head>
	<body>
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
			<fieldset>
				<legend>Forget your password</legend>
				<div>
					<label for="mail">Please enter your Email:</label>
					<input type="email" id="mail" name="email" placeholder="please enter your email" required/>
				</div>
				<input type="submit" name="submit" value="Send password" />
			</fieldset>
		</form>
	</body>
</html>
<?php 
	if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit'])){

		//variables 
		$count =0;
		$email="";

		//test input fn
		function test_input ($data){

			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		if (isset($_POST['email'])){

			$email=test_input($_POST['email']);
			if (!filter_var($email , FILTER_VALIDATE_EMAIL)){
				echo "please enter a valid email";
				$count++;
			}
		}
		else {
			echo "email field is required";
			$count++;
		}
		if ($count >0){
			
			exit();
		}
		//connection to db
		require 'db_connection.php';

		$sql="SELECT * FROM users WHERE email = '$email' ";

			if ($stmt = $conn->prepare($sql)) {
			
			
		 		$query=mysqli_query($conn,$sql);
				$num_of_rows=mysqli_affected_rows($conn);					
				$row=mysqli_fetch_assoc($query);
		 		//$stmt->store_result();
				// Store the result so we can check if the account exists in the database.
				if ($num_of_rows == 0) {
						// Username already exists
					echo 'No email found , Please enter a registerd Mail ';
						exit();
			 	} 
			 	else {
			 		
			 		echo "sent please check your email";
			 		sleep(4);
			 		
			 		$to = $email;
					$subject = "Flagx recovery Password";

					$message = "
					<html>
					<body>
						<div style='width:80%;height:400px;border:1px solid #E44D3A;background-color:#F2F2F2;padding-left:3%;color:#435160'>
						<h1 style='color:#E44D3A;'>HI ".$row['username']." </h1>
						<p>Thank you for messaging us. You're receiving this message because you forgot your password  (If this is not you please ignore this message)</p>

				<p>If you have chosen some of the value-added paid services, please note that they will be approved and provisioned within the next 1-24h by one of our sales representatives!
					</p>
						<p>we are very sorry that you forget your password .</p>

						 <p><span style='font-weight:bold'>your password is:' </span>".$row['password']."'</p><br/><br/><br/>

						 
							<p>Best Regards</p>
							<p>FLAGX Team</p>
							<p>www.FLAGX.dx.am</p>

						</div>
					</body>
					</html>
					";
					echo $message;
					
					// Always set content-type when sending HTML email
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

					// More headers
					$headers .= 'From: <omarwhadidi@hotmail.com>' . "\r\n";
					$headers .= 'Cc: myboss@example.com' . "\r\n";

					//mail($to,$subject,$message,$headers);
					//no smtp server in localhost
			 		
					echo "<script>document.location='index.php'</script>";

					
			 	}
			 $stmt->close();
			 $conn->close();

		 	} 
			 


		

	}
?>