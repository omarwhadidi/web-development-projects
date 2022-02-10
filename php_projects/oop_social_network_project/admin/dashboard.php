<?php 
ob_start();


require 'includes/core/config.php';
include 'classes/dbh.classes.php';
include 'classes/session.classes.php';
include 'classes/model/admin.classes.php';
include 'classes/controller/admin-contr.classes.php';



// ----------------------------------- Session Validation --------------------------------------

session_start();


$session = new Session();
$session->ValidateAdminSession();
$session->ValidateLogoutTokenSession();
$session->LimitSessionDuration();

$username = $_SESSION['username'] ;
$logouttoken = $_SESSION['logout_token'];

// ----------------------------------- Session Validation ---------------------------------------


$user = new AdminContr();

$user->SetUsername($username);
$userData = $user->GetUserInfo($username) ; 




if (isset($_POST['activate'])){

    $usern = $_POST['activate'];
    $user->ActivateAccount($usern);

}

if (isset($_POST['deactivate'])){

    $usern = $_POST['deactivate'];
    $user->DeactivateAccount($usern);

}

if (isset($_POST['makemoderator'])){

    $usern = $_POST['makemoderator'];
    $user->UpgradeAccount($usern);

}

if (isset($_POST['makeuser'])){

    $usern = $_POST['makeuser'];
    $user->DowngradeAccount($usern);

}


include 'includes/templates/header.inc.php';
?>



    <?php
   
        if (isset($_REQUEST['searchuser'])){

            $usern = escape($_REQUEST['searchuser']);
            $searchresult = $user->GetUsername($usern);
            echo '<div id="result">';
            foreach ($searchresult as $userdata){

              echo '<p ><img class="rounded-circle" width="45" src="../'.$userdata['profile_pic'].'" > 
              '.$userdata['firstname'].' '.$userdata['lastname'].'</p>';  

            }
            echo '</div>';

        }
    ?>
	


    <div class="container-fluid gedf-wrapper">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="h5">Welcome @<?php echo $username ;?></div>
                        <div class="h7 text-muted">Fullname : <?php echo $userData['firstname'].' '.$userData['lastname'] ;?></div>
                        <div class="h7">
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="h6 text-muted">Followers</div>
                            <div class="h5">5.2342</div>
                        </li>
                        <li class="list-group-item">
                            <div class="h6 text-muted">Following</div>
                            <div class="h5">6758</div>
                        </li>
                        <li class="list-group-item">Vestibulum at eros</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 gedf-main">





            </div>
            <div class="col-md-3">
                <div class="card gedf-card">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                            card's content.</p>
                        <a href="#" class="card-link">Card link</a>
                        <a href="#" class="card-link">Another link</a>
                    </div>
                </div>
                <div class="card gedf-card">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                                card's content.</p>
                            <a href="#" class="card-link">Card link</a>
                            <a href="#" class="card-link">Another link</a>
                        </div>
                    </div>
            </div>
        </div>
    </div>
	
	<div>
        <?php  

            $users = $user->GetAllUsers();

            echo "<h3>The list of users  and their Details :</h3>";
            echo "<table>";
            echo "<tr><th align='left'>user ID </th><th>UserName </th><th> Full Name </th><th>email </th><th>Gender </th><th>CLient IP </th><th>Regstatus </th><th>Permissions </th><th>Change Status </th><th>Change permissions </th></tr>";

            
             foreach ($users as $user) {

                $name = $user["username"];
                $userpermissions = (new AdminContr)->GetUserPermissions($name); // you must define a new object inside an array otherwise you will get an error             
            
                echo "<tr>
                    <td>".$user["id"]."</td>
                    <td>".$user["username"]."</td>
                    <td>".$user["firstname"].' '.$user['lastname']."</td>
                    <td>".$user["email"]."</td>
                    <td>".$user["gender"]."</td>
                    <td>".$user["client_ip"]."</td>
                    <td>".$user["regstatus"]."</td>
                    <td>".$userpermissions['permissions']."</td>
                    <td><form method='POST' ><input type='hidden' name='deactivate' value='$name'/>
                           <button type='submit' class='alert alert-danger'>Deactivate Account</button> 
                        </form>
                        <form method='POST' ><input type='hidden' name='activate' value='$name'/>
                            <button type='submit' class='alert alert-success' style='width:100%'>Activate Account</button> 
                        </form></td>
                    <td><form method='POST' ><input type='hidden' name='makeuser' value='$name'/>
                           <button type='submit' class='alert alert-danger'>Downgrade to User</button> 
                        </form>
                        <form method='POST' ><input type='hidden' name='makemoderator' value='$name'/>
                            <button type='submit' class='alert alert-success' style='width:100%'>Make Moderator</button> 
                        </form></td>

                    </tr>";
             }

            echo "</table>";
            echo '<hr>';

             

        ?>   
    </div>			

    
      
    }

</script>
<?php 

include 'includes/templates/footer.inc.php';


?>



