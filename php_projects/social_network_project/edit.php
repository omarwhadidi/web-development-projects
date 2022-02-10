<?php 
@ob_start();
session_start();
session_regenerate_id(); //to prevent session fixation
 
 	  if (!isset($_SESSION['username']) ){
 	 		exit(header('location:index.php'));
 	 		/*use exit or die to stop executing the page  
 	 		  because if i use curl <url> command it will display the page
 	 		  so to prevent that use exit or die after the redirect */
 	  }
?>
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
				height:550px;
			}
			legend {
				background-color:#E44D3A;
				color:#fff;
				width:150px;
				padding:15px 0 15px 20px;
				

			}
			label {
				cursor:pointer;
				

			}
			form input {

				width:20%;
				height:50%;
				margin-left:40px;
				padding-left:10px;

			}
			form input[type='submit']{

				margin-left:40%;
			}
			form select {

				width:20%;
				height:50%;
				margin-left:10px;
				padding-left:10px;
				cursor:pointer;
			}
			.no_margin {

			
				margin-left:10px;
				
			}
			.extra_margin {

			
				margin-left:73px;
				
			}
			.design{
				height:60px;
				margin-top:20px;
			}
			.design label{

				text-transform:capitalize;
			}


		</style>

	</head>
	<body>
		
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
				<fieldset>
					<legend>Edit Your Profile</legend>
					<div class="design">
						<label for="name">update your username:</label>
						<input type="text" id="name" name="newname" placeholder="update your username" />
					</div>
					<div class="design">
						<label for="pass">update your password:</label>
						<input type="password" id="pass" name="newpass" placeholder="update your password" />
					</div>
					<div class="design">
						<label for="rel">update your martial status:</label>
						<select id="rel" name="relationship">
							<option value="">your martial status</option>
							<option value="single">single</option>
							<option value="married">Married</option>
							<option value="divorsed">divorsed</option>
							<option value="in a relationship">In a relationship</option>
						</select>
						
					</div>
					<div class="design">
						<label for="age">update your age:</label>
						<input type="number" class="extra_margin" id="age" name="age" placeholder=" your age" />
					</div>
					<div class="design">
						<label for="job">update your job:</label>
						<input type="text"  class="extra_margin" id="job" name="job" placeholder=" your job" />
					</div>
					<div class="design">
						<label for="pic">update your profile picture:
						</label>
						<input type="file" id="pic" name="image" />
						<br/><br/>
						<input type="submit"  name="update" value="update" />
					<div>
				</fieldset>
			</form>


	</body>
</html>
<?php 
	if(isset($_POST['update'])){


		//define variables
		$sessionk=$_SESSION['username'];
		$image=$new_name=$new_pass=$new_gender=$age=$relationship='';

		require 'db_connection.php';

		//testing input
		function test_input ($data){

			$data =trim($data);
			$data =stripslashes($data);
			$data =htmlspecialchars($data);

			return $data;
		}

		//error count
		$count=0;

		
		if (file_exists($_FILES['image']['tmp_name'])){
				//image variables
			$image_name=$_FILES['image']['name'];
			$image_type=$_FILES['image']['type'];
			$image_tmpname=$_FILES['image']['tmp_name'];
			$image_size=$_FILES['image']['size'];

			$allowed_extensions= array("jpeg","jpg","png");
			

			$tmp = explode('.',$image_name );
			$image_extension = strtolower(end($tmp));
			 			//explode divide the array into smaller array after finding the .
						//end() get the final value of the array

				 if (!in_array($image_extension,$allowed_extensions )){
						echo "this extention is not allowed";
						$count++;
				 }
				if ($image_size > 4194304){

					echo "image cant be larger than 4 Mb";
					$count++;
				}

				$image=rand(1 , 10000)."_".$image_name;
				if ($count ==0){
						move_uploaded_file($image_tmpname , "usersimages\\".$image);
						
					}

					$picture_store="usersimages\\\\".$image;
	 			 $sql="UPDATE `users` SET `picture` = '$picture_store' WHERE `users`.`username` ='$sessionk'";

	 			if($stmt = $conn->prepare($sql)){

		 			

		 			if(!$stmt->execute()){
					
					echo "<script>alert('coudnt insert image')</script>";
					$count++;

					}
					

				} else {
						// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
						echo 'Could not prepare statement!';
				}


		}


		//update name
		if (!empty($_POST['newname'])){

			$new_name=test_input($_POST['newname']);


			$sql="UPDATE `users` SET `username` = '$new_name' WHERE `users`.`username` ='$sessionk'";

		

			if (!mysqli_query($conn, $sql)) {
			     echo "Error updating record: " . mysqli_error($conn);
			    $count++;
			} 
			

			

		}

		//update password
		if (!empty($_POST['newpass'])){

			$new_pass=test_input($_POST['newpass']);


			$sql="UPDATE `users` SET `password` = '$new_pass' WHERE `users`.`username` ='$sessionk'";

		

			if (!mysqli_query($conn, $sql)) {
			   echo "Error updating record: " . mysqli_error($conn);
			} 
			

			

		}

		//update age
		if (!empty($_POST['age'])){

			$age=test_input($_POST['age']);


			//prepare and bind

	 		 $sql="UPDATE `users` SET `age` = '$age' WHERE `users`.`username` ='$sessionk'";

	 			if($stmt = $conn->prepare($sql)){

		 	
		 			if(!$stmt->execute()){
					
				
						echo "<script>alert('coudnt insert age')</script>";
						$count++;
					}
					
				} else {
						// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
						echo 'Could not prepare statement!';
				}

		
			}

			//update relationship
			if (!empty($_POST['relationship'])){

			$relationship=test_input($_POST['relationship']);


			//prepare and bind

	 		 $sql="UPDATE `users` SET `relationship` = '$relationship' WHERE `users`.`username` ='$sessionk'";

	 			if($stmt = $conn->prepare($sql)){

		 			

		 			if(!$stmt->execute()){
					
					echo "<script>alert('coudnt insert relationship')</script>";
					$count++;
						
					}
					
				} else {
						// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
						echo 'Could not prepare statement!';
				}

		
			}
				
	
			//update work
			if (!empty($_POST['job'])){

			$work=test_input($_POST['job']);


			//prepare and bind

	 		 $sql="UPDATE `users` SET `job` = '$work' WHERE `users`.`username` ='$sessionk'";

	 			if($stmt = $conn->prepare($sql)){

		 	
		 			if(!$stmt->execute()){
					
				
						echo "<script>alert('coudnt insert job')</script>";
						$count++;
					}
					
				} else {
						// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
						echo 'Could not prepare statement!';
				}

		
			}
			mysqli_close($conn);

			if ($count ==0){
				die(header('location:home.php'));
			}
	}
?>