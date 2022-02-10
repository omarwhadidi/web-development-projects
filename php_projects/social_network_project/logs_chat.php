<?php 
//ajax chat 
require 'db_connection.php';
$q ="SELECT * FROM chat ORDER BY message_id DESC";
								$query=mysqli_query($conn,$q);
								$num_of_rows=mysqli_affected_rows($conn);
									
								
								for ($i=0;$i<$num_of_rows;$i++){
									$row=mysqli_fetch_assoc($query);
					echo "<P><span >".$row['username'].":</span>".$row['message']."<p style='text-align:right;font-size:16px;color:#000'>".$row['message_date']."</p></p>";

								}



?>