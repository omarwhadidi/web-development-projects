<?php 
require 'db_connection.php';
	$suser='';

	function test_input ($data){

				$data=trim($data);
				$data=strip_tags($data);
				$data=htmlspecialchars($data);
				return $data;

				}
	
	if (!empty($_GET['search'])){

		$suser=test_input($_GET['search']);

		$q ="SELECT * FROM users WHERE username LIKE '%$suser%' ";
								$query=mysqli_query($conn,$q);
								$num_of_rows=mysqli_affected_rows($conn);
									
								
								for ($i=0;$i<$num_of_rows;$i++){
									$row=mysqli_fetch_assoc($query);
		echo "<p><span style='display:inline-block;width:180px'>Name: ".$row['username']."</span><span style=''>age:".$row['age']."</span><span style='float:right'>".$row['relationship']."</span></p>";

								}
						}




			if (!empty($_POST['username'])){

				$check=$_POST['username'];
				$sql="SELECT * FROM users WHERE username = '$check' ";

				$query=mysqli_query($conn,$sql);
				$num_of_rows=mysqli_affected_rows($conn);

				if ($num_of_rows >0){
					echo "<i style='color:#E4324C' class='fas fa-times-circle'></i>";
				}
				else {
					echo "<i class='fas fa-check-circle'></i>";
				}
			}

			if (!empty($_POST['email'])){

				$checkemail=$_POST['email'];
				$sql="SELECT * FROM users WHERE email = '$checkemail' ";

				$query=mysqli_query($conn,$sql);
				$num_of_rows=mysqli_affected_rows($conn);

				if ($num_of_rows >0){
					echo "<i style='color:#E4324C' class='fas fa-times-circle'></i>";
				}
				else {
					echo "<i class='fas fa-check-circle'></i>";
				}
			}

