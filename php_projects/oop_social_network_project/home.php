<?php 
ob_start();

 
require 'includes/core/config.php';
include 'classes/dbh.classes.php';
include 'classes/session.classes.php';
include 'classes/model/user.classes.php';
include 'classes/controller/user-contr.classes.php';



// ----------------------------------- Session Validation --------------------------------------

session_start();
session_regenerate_id();   // Prevent Session Fixation


$session = new Session();
$session->ValidateUserSession();
$session->ValidateLogoutTokenSession();
$session->LimitSessionDuration();

$username = $_SESSION['username'] ;
$logouttoken = $_SESSION['logout_token'];

// ----------------------------------- Session Validation --------------------------------------


$user = new UserContr();
$user->SetUsername($username);
$userData = $user->GetUserInfo($username) ; 


if (isset($_POST['share'])){

    $post = escape($_POST['userpost']);

    $user->SharePost($post);

}

if (isset($_POST['likepost'])){

    $usern = escape($_POST['likepost']);
    $pid = escape($_POST['lpostid']);

     $user->LikePost($usern,$pid);

}


 include 'includes/templates/header.inc.php';
?>

<style type="text/css">

button{
 background: none;
 border: none;
 color: blue;

}
button:hover{
   
   text-decoration: underline;
}

</style>


    <?php
    /*    if (isset($_REQUEST['searchuser']) && !empty($_REQUEST['searchuser'])  ){

            $usern = escape($_REQUEST['searchuser']);
            $searchresult = $user->GetUsername($usern);
            echo '';
            if (is_array($searchresult)){
                foreach ($searchresult as $userdata){

                  echo '<p ><img class="rounded-circle" width="45" src="'.$userdata['profile_pic'].'" > 
                  '.$userdata['firstname'].' '.$userdata['lastname'].'</p>';  

                }
            }
        

    }*/
    ?>


<nav class="navbar navbar-light bg-white">
        <a href="#" class="navbar-brand">Bootsbook</a>
        <form class="form-inline" method="GET" action="">
            <div class="input-group">
                <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2" name="searchpost">
                <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="submit"  id="button-addon2">
                            <i class="fa fa-search"></i>
                        </button>
                </div>
            </div>
        </form>
</nav>


    <div class="container-fluid gedf-wrapper">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <img src="<?php echo $userData['profile_pic'];?>" >
                        <div class="h5">Welcome @<?php echo $username ;?>
                            
                        </div>
                        <div class="h7 text-muted">Fullname : <?php echo $userData['firstname'].' '.$userData['lastname']  ;?></div>
                        <div class="h7"><a href="update.php" target="_self">edit your profile</a>
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

                <!--- \\\\\\\Post-->
                <form method="POST" action="" class="card gedf-card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="posts-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="true">Make
                                    a publication</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="images-tab" data-toggle="tab" role="tab" aria-controls="images" aria-selected="false" href="#images">Images</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                                <div class="form-group">
                                    <label class="sr-only" for="message">post</label>
                                    <textarea name="userpost" class="form-control" id="message" rows="3" placeholder="What are you thinking?"></textarea>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label" for="customFile">Upload image</label>
                                    </div>
                                </div>
                                <div class="py-4"></div>
                            </div>
                        </div>
                        <div class="btn-toolbar justify-content-between">
                            <div class="btn-group" style="margin-top:10px;">
                                <button type="submit" name="share" class="btn btn-primary">share</button>
                            </div>
                            <div class="btn-group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-link dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fa fa-globe"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1">
                                    <a class="dropdown-item" href="#"><i class="fa fa-globe"></i> Public</a>
                                    <a class="dropdown-item" href="#"><i class="fa fa-users"></i> Friends</a>
                                    <a class="dropdown-item" href="#"><i class="fa fa-user"></i> Just me</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Post /////-->

     <?php  

        if (isset($_REQUEST['searchpost']) && !empty($_REQUEST['searchpost'])){

            $usern = escape($_REQUEST['searchpost']);

            // Allow Search by username , Firstname , Lastname

            $userslist = $user->GetUsername($usern);

            // Get List of Usernames 

            foreach ($userslist as $userlist){

                $usernb = $userlist['username']; 

                // Get All Posts Of Each User
                $posts = $user->GetUserPosts($usernb);

                // Print All Posts Of Each User

                foreach ($posts as $post) {
                    
                    $postuser = $post["username"];
                    $postuserdata = $user->GetUserInfo($postuser) ; 
                    echo '
                               <!--- \\\\\\\Post-->
                         <div class="card gedf-card" style="margin-top:10px;">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mr-2">
                                            <img class="rounded-circle" width="45" src="'.$postuserdata["profile_pic"].'" alt="">
                                        </div>
                                        <div class="ml-2">
                                            <div class="h5 m-0">'.$post["username"].'</div>
                                            <div class="h7 text-muted"><span>Likes: '.$post["likes"].'</span></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="dropdown">
                                            <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                                <div class="h6 dropdown-header">Configuration</div>
                                                <a class="dropdown-item" href="#">Save</a>
                                                <a class="dropdown-item" href="#">Hide</a>
                                                <a class="dropdown-item" href="#">Report</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-body">
                                <div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i>'.$post["postdate"].' ago</div>
                                <a class="card-link" href="#">
                                    <h5 class="card-title">Lorem ipsum dolor sit amet, consectetur adip.</h5>
                                </a>

                                <p class="card-text">
                                     '.$post["post"].'
                                </p>
                            </div>
                            <div class="card-footer">
                                <a href="#" class="card-link"> 
                                    <form method="POST" id="LIP" action="" style="Display:inline;">
                                     <input type="hidden" name="likepost" value="'.$post["username"].'"/>
                                     <input type="hidden" name="lpostid" value="'.$post["pid"].'"/>
                                     <button type="submit" class="card-link" name="submitlike"/><i class="fa fa-gittip"></i> Like</button>
                                 </form>
                                </a>
                                <a href="#" class="card-link"><i class="fa fa-comment"></i> Comment</a>
                                <a href="#" class="card-link"><i class="fa fa-mail-forward"></i> Share</a>
                            </div>
                        </div>
                        <!-- Post /////--> ';

                }

            } 

            

        }
        else {

            $posts = $user->GetAllPosts();

            foreach ($posts as $post) {
                    
                    $postuser = $post["username"];
                    $postuserdata = $user->GetUserInfo($postuser) ; 
                    echo '
                       <!--- \\\\\\\Post-->
                 <div class="card gedf-card" style="margin-top:10px;">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mr-2">
                                    <img class="rounded-circle" width="45" src="'.$postuserdata["profile_pic"].'" alt="">
                                </div>
                                <div class="ml-2">
                                    <div class="h5 m-0">'.$post["username"].'</div>
                                    <div class="h7 text-muted"><span>Likes: '.$post["likes"].'</span></div>
                                </div>
                            </div>
                            <div>
                                <div class="dropdown">
                                    <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                        <div class="h6 dropdown-header">Configuration</div>
                                        <a class="dropdown-item" href="#">Save</a>
                                        <a class="dropdown-item" href="#">Hide</a>
                                        <a class="dropdown-item" href="#">Report</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i>'.$post["postdate"].' ago</div>
                        <a class="card-link" href="#">
                            <h5 class="card-title">Lorem ipsum dolor sit amet, consectetur adip.</h5>
                        </a>

                        <p class="card-text">
                             '.$post["post"].'
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="card-link"> 
                            <form method="POST" id="LIP" action="" style="Display:inline;">
                             <input type="hidden" name="likepost" value="'.$post["username"].'"/>
                             <input type="hidden" name="lpostid" value="'.$post["pid"].'"/>
                             <button type="submit" class="card-link" name="submitlike"/><i class="fa fa-gittip"></i> Like</button>
                         </form>
                        </a>
                        <a href="#" class="card-link"><i class="fa fa-comment"></i> Comment</a>
                        <a href="#" class="card-link"><i class="fa fa-mail-forward"></i> Share</a>
                    </div>
                </div>
                <!-- Post /////--> ';

            }

        }
                ?>
                



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
	
					



<?php 

include 'includes/templates/footer.inc.php';


?>



