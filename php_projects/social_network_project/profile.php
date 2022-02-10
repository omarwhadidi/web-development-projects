<?php 
@ob_start();
session_start();
session_regenerate_id(); //to prevent session fixation
 	

 	  if (!isset($_SESSION['username']) ){

 	  	if (headers_sent()) {
    		die("Redirect failed. Please click on this link: <a href=...>");
				}
		else{
   			 exit(header('location:index.php'));
			}
 	 		 
 	 		/*use exit or die to stop executing the page  
 	 		  because if i use curl <url> command it will display the page
 	 		  so to prevent that use exit or die after the redirect */
 	  }
 	  $time = $_SERVER['REQUEST_TIME'];
		

		/**
		* for a 15 minute timeout, specified in seconds
		*/
		$timeout_duration = 900;

		/**
		* Here we look for the user's LAST_ACTIVITY timestamp. If
		* it's set and indicates our $timeout_duration has passed,
		* remove previous $_SESSION data and start a new one.
		*/
		if (isset($_SESSION['LAST_ACTIVITY']) && 
		   ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
		    session_unset();
		    session_destroy();
		    echo "<script>window.location='index.php'</script>";
		    
		}

		/**
		* Finally, update LAST_ACTIVITY so that our timeout
		* is based on it and not the user's login time.
		*/
		$_SESSION['LAST_ACTIVITY'] = $_SERVER['REQUEST_TIME'];
 	
 /*
	if (!header("referrer:index.php")){
			
			header("location:index.php");
	} */
?> 
<html>
	<head lang="en-us">
		<title>Flagx</title>
		                              <!--META TAGS -->
		<meta charset="utf-8" />
		<meta name="description" content="Connect with friends and pentesters and other people you know. Share photos and videos, send messages and get updates." />
		<meta name="keyword" content="flagx , flag , social , network , social network , connect , " />
		<meta name="author" content="omar El hadidi"  />
		<meta name="robots" content="index,follow" />
		<meta name="viewport" content="width=device-width,initial-scale=1.0" />


										<!--LNIK TAGS -->
		<link rel="stylesheet" href="css/normalize.css" /> 
		<link rel="stylesheet" href ="css/bootstrap.min.css" />
		<link rel="stylesheet" href ="fonts/all.css" />		
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Sofia' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="css/page.css" type="text/css"/>
										<!--fav icons  -->
		<link rel="icon" href="images/favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
		
		<link rel="apple-touch-icon" href="favicon.ico">  						<!--APPLE FAVICONS -->

		<style>
		
		</style>
		
	</head>
	<body>
		<header>
			<div class="site_name">
				<h1>flagX</h1>
			</div>
			<div class="search">
				<form id='sform' method="get" action="">
					<input type="text" id='search' name="search" placeholder="search..." autocomplete="off" onkeyup="usearch()"/>
					<input type='button' /><i  class="overwride fas fa-search"></i>
				</form>
			</div>
			<nav>
				<li><a href="home.php" target="_self">home</a></li>
				<li><a href="#" target="_self">profile</a></li>
				<li><a href="logout.php" target="_self">logout</a></li>
			</nav>
		</header>
		<div class="contain">
			<div id="result">rtn</div>
			<div class="wallpaper" style="background-image: url('images/cover.jpg');">
				
			</div>
				<div class="wrapper">
											<!-- left side bar start -->
				<aside class="left">
					<section class="info">
						<div class="empty"></div>
						<div class="photo">
								<?php
								require 'db_connection.php';

						$sessionk=$_SESSION['username'];
								$sql ="SELECT * FROM users WHERE `users`.`username` = '$sessionk'";
									$query=mysqli_query($conn,$sql);
									$num_of_rows=mysqli_affected_rows($conn);
									
										$row=mysqli_fetch_assoc($query);
										if ($row['job']==''){
											$row['job']="Not stated";
										}
										if ($row['age']==''){
											$row['age']="NS";
										}
										if ($row['picture']==''){
											$row['picture']="images/download.png";
										}
										if ($row['relationship']==''){
											$row['relationship']="Not Stated";
										}
								echo "<img src=".$row['picture']." alt='profile picture' title='profile picture' />
							<h3>". $_SESSION['username'] ."</h3>
							<p>".$row['job']."</p>
						</div>
						<div class='age'>
							
										<h3>age</h3>
												<p>".$row['age']."</p>
			
											</div>
											<div class='relationship'>
												<h3>relationship</h3>
												<p>".$row['relationship']."</p>";
							?>
						</div>
					</section>

					<section class="ads">
						<span>google ads</span>
					</section>
				</aside>
												<!-- left side bar end  -->
												<!-- main section start  -->
				<main>
				

						<?php	
						
						$sql ="SELECT * FROM posts WHERE username='$sessionk' ORDER BY post_time DESC";
						$query=mysqli_query($conn,$sql);
						$num_of_rows=mysqli_affected_rows($conn);
						
						for ($i=0;$i<$num_of_rows;$i++)
						{
							$row=mysqli_fetch_assoc($query);

							$sqll ="SELECT * FROM users WHERE username='$sessionk'";
							$queryy=mysqli_query($conn,$sqll);
							$roww=mysqli_fetch_assoc($queryy);
							if ($roww['picture']==''){
								$roww['picture']="images/download.png";
							}
							echo "

							<section>
								<div class='post'>
									<div class='time_post'>
										<img src='".$roww['picture']."' alt='profile photo' title='profile photo' />
										<p class='editp'>".$row['username']."</p>
										<p class='edittime'>".$row['post_time']."</p>
									</div>
									<div class='comment'>
									".
									$row['comment']."
									</div>
								</div>
								<div class='likes'>
									<div class='bt_like'>
										<button name='like' value='true'><i class='overwride2 fas fa-heart'></i>like</button>
										<div class='icon'>
											
										</div>
									</div>
								</div>
							</section>

							";
						}
						?>
				

					
			    </main>
			    									<!-- main section end  -->
			    									<!-- right side bar  -->
				<aside class="right">
					<section class="top_right">
						<p>welcome</p>
						<p><?php echo $_SESSION['username'] ;?></p>
						<p>to flagx</p>
						<a href="edit.php" target="_blank">edit your profile</a>
					</section>
					<section class="game ads">
						<h4>Entertainment</h4>
						<p>flagx is conserned about it's users ; thus we assure you with  quality and up to date services. Our games will keep you entertained , Whether your preferences or passion for any other game are , we promise interesting perspectives on life and society.</p>
						<a href='game.php' target='_blank'>play a game </a>
					</section>

				</aside>
			</div>
		</div>

			<script src="js/all.js" ></script>						<!--fontawesome js file -->
			<script src="js/jquery.js"></script>
			<script>
				
				function usearch() {
				  
				  
				  var search= document.getElementById("search").value ;

				  
					  if (search == ''){
					  	document.getElementById("result").style.display='none' ;
					  }
					  else {
					  	document.getElementById("result").style.display='block' ;
					  	var xhttp = new XMLHttpRequest();
					  xhttp.onreadystatechange = function() {
				    if (this.readyState == 4 && this.status == 200) {
				    document.getElementById("result").innerHTML = this.responseText;
				    }
				  };
				 xhttp.open("GET", "search.php?search="+search, true);
				  xhttp.setRequestHeader("content-type","application/x-www-form-urlencoded");
				  xhttp.send(); 
				  //document.getElementById('sform').reset();
					  }
				  
				}
			</script>
	</body>
</html>
<?php 
		if (isset($_POST['share'])){

				// validation function
				function test_input ($data){

				$data=trim($data);
				$data=strip_tags($data);
				$data=htmlspecialchars($data);
				return $data;

				}

				if (!empty($_POST['post'])){
					$user_post=test_input($_POST['post']);
				}
						
				$date=date("F d, Y h:i:s A");

				

				$sql="INSERT INTO posts (comment ,post_time) 
	 		 	VALUES (? ,?)";

	 			if($stmt = $conn->prepare($sql)){

		 			$stmt->bind_param('ss',$user_post,$date);
		 			

		 			$stmt->execute();
					
					
				} else {
						// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
						echo 'Could not prepare statement!';
				}

		 			//close connection
		 			$stmt->close();
		 			$conn->close();	
		}
?>