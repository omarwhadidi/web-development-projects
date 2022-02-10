<?php 
//used to load all posts when using ajax without clicking submit button
require 'db_connection.php';
					$sql ="SELECT * FROM `posts`,`users` where users.username = posts.username ORDER BY post_time DESC";
						$query=mysqli_query($conn,$sql);
						$num_of_rows=mysqli_affected_rows($conn);
						
						for ($i=0;$i<$num_of_rows;$i++)
						{
							$row=mysqli_fetch_assoc($query);
							if ($row['picture']==''){
								$row['picture']="images/download.png";
							}
							echo "

							<section>
								<div class='post'>
									<div class='time_post'>
										<img src='".$row['picture']."' alt='profile photo' title='profile photo' />
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
										<button type='submit' formmethod='get' formaction='chat.php' id='lk' name='like' value='true' onclick='return like()'><i class='overwride2 fas fa-heart'></i>like</button>
										
									</div>
									<span id='nblike' style='position:absolute;top:0px;left:90%'>l</span>
								</div>
							</section>
							<input type='hidden' id='pidd' name='post_id' value='".$row['post_id']."' />
							";
						}

?>

