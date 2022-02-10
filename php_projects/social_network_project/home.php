<?php 
@ob_start();
session_start();
session_regenerate_id(); //to prevent session fixation
 	

 	  if (!isset($_SESSION['username']) ){
 	 		if (headers_sent()) {
    		die("Redirect failed. ");
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

		

 	require 'db_connection.php';
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
	<body >
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
				<li><a href="#" target="_self">home</a></li>
				<li><a href="profile.php" target="_self">profile</a></li>
				<li><a href="logout.php" target="_self">logout</a></li>
			</nav>
		</header>
		
		<div class="contain">
			<div id="result"></div>
				<div class="wrapper">
											<!-- left side bar start -->
				<aside class="left">
					<section class="info">
						<div class="empty"></div>
						<div class="photo">
						<?php
						$sessionk=$_SESSION['username'];
								$sql ="SELECT * FROM users WHERE `users`.`username` = '$sessionk' ";
									$query=mysqli_query($conn,$sql);
									$num_of_rows=mysqli_affected_rows($conn);
									
										$row=mysqli_fetch_assoc($query);
										if ($row['job']==''){
											$row['job']="Not stated";
										}
										if ($row['age']==''){
											$row['age']=0;
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
				<main >
					<section class="first_section">
						<form action="" method="get" id="firstform">
							<textarea id="aj" name="post" placeholder="What's on your mind?"></textarea>
							<input type="button" name="share" value="post"
							 onclick=" return comment()"/>
						</form>
					</section>

					<article id="main">
						
					</article>
				

					
			    </main>
			    									<!-- main section end  -->
			    									<!-- right side bar  -->
				<aside class="right">
					<section class="top_right">
						<p>welcome</p>
						<p><?php echo $_SESSION['username'] ;?></p>
						<p>to flagx</p>
						<a href="edit.php" target="_self">edit your profile</a>
					</section>
					<section class="ads">
						<div  class="chat_header">
							<h3>chat</h3>
						</div>
						<div id="chat_body" class="chat_body">message</div>
						<div class="chat_messages">
							<form action="" method="get" id="secondform">
								<textarea id="message" name="message"></textarea>
								<input type="button"  name="send" value="send" onclick="return chat()"/>
							</form>
						</div>
					</section>

				</aside>
			</div>
		</div>

			<script src="js/all.js" ></script>						<!--fontawesome js file -->
			<script src="js/jquery.js"></script>
			<script>
				
					function like (){

						var like=document.getElementById('lk').value;
						var pid=document.getElementById('pidd').value;
						console.log(like);
						console.log(pid);

						var xhttp = new XMLHttpRequest();
				 		 xhttp.onreadystatechange = function() {
				    if (this.readyState == 4 && this.status == 200) {
				   		 document.getElementById("nblike").innerHTML = this.responseText;
				   			 }
				  };
					 xhttp.open("GET", "chat.php?like="+like, true);
				  xhttp.setRequestHeader("content-type","application/x-www-form-urlencoded");
				  xhttp.send(); 

							}

				function chat() {
				  
				  
				  var message= document.getElementById("message").value ;
				  
				 
				  var xhttp = new XMLHttpRequest();
				  xhttp.onreadystatechange = function() {
				    if (this.readyState == 4 && this.status == 200) {
				    document.getElementById("chat_body").innerHTML = this.responseText;
				    }
				  };
				 xhttp.open("GET", "chat.php?message="+message+"&send=send", true);
				  xhttp.setRequestHeader("content-type","application/x-www-form-urlencoded");
				  xhttp.send(); 
				  document.getElementById('secondform').reset();
				}


				function comment() {
				  
				  
				  var post= document.getElementById("aj").value ;
				  
				  
				  var xhttp = new XMLHttpRequest();
				  xhttp.onreadystatechange = function() {
				    if (this.readyState == 4 && this.status == 200) {
				    document.getElementById("main").innerHTML = this.responseText;
				    }
				  };
				 xhttp.open("GET", "chat.php?post="+post+"&share=send", true);
				  xhttp.setRequestHeader("content-type","application/x-www-form-urlencoded");
				  xhttp.send(); 
				  document.getElementById('firstform').reset();
				}


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


				$(document).ready(function(e) {

					$.ajaxSetup({cache:false});
					setInterval( function() { $('#main').load('logs.php'); }, 1000);
					setInterval( function() { $('#chat_body').load('logs_chat.php'); }, 500);

					
				
					});
				

			</script>
	</body>
</html>
