

<?php

$server_name="localhost";
			 $sql_name="root";
	 		$sql_password="";
	 		$db_name="flagx";

			//create connection
			 $conn= new mysqli($server_name,$sql_name,$sql_password,$db_name);

			//check connection
			 if ($conn->connect_error){
	 			die("Cannot connect to database ".$conn->connect_error);

			 }
	 			


?>




