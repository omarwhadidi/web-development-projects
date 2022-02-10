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


if (isset($_POST['share'])){

    $post = escape($_POST['userpost']);

    $user->SharePost($post);

}

if (isset($_POST['deletepost'])){

    $usern = $username;
    $pid = escape($_POST['postid']);

    $user->DeletePost($usern,$pid);

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

	
<div class="row " style="margin-bottom: 70px;">
    <div class="col-xl-13 col-md-12 col-sm-12 ">

        <!-- Profile widget -->
        <div class="bg-white shadow rounded " style="height: 300px;">
            <div class="px-4 pt-0 pb-4 bg-dark" style="background-image: url('Uploads/avatar6.png');background-repeat: no-repeat;background-size: 100% 100%; height: 100%;width: 100%">
               <div style="padding-top: 15%">
                    <img src="https://bootstrapious.com/i/snippets/sn-profile/teacher.jpg" alt="..." width="130" class="rounded mb-2 img-thumbnail">
                    <div class="media-body mb-5 text-white">
                        <h4 class="mt-0 mb-0">Manuella Tarly</h4>
                        <p class="small mb-4"> <i class="fa fa-map-marker mr-2"></i>San Farcisco</p>
                    </div>
                </div>
                </div>
            </div>

           
        </div><!-- End profile widget -->

    </div>
</div>


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
                            <div class="btn-group">
                                <button type="submit" name="share" class="btn btn-primary">share</button>
                            </div>
                            <div class="btn-group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
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

                $posts = $user->GetUserPosts($username);

                 foreach ($posts as $post) {
                               
                    
                    echo '
                       <!--- \\\\\\\Post-->
                <div class="card gedf-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mr-2">
                                    <img class="rounded-circle" width="45" src="../'.$userData['profile_pic'].'" alt="">
                                </div>
                                <div class="ml-2">
                                    <div class="h5 m-0">'.$post["username"].'</div>
                                    <div class="h7 text-muted">Likes: '.$post["likes"].'</div>
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
                                        <a class="dropdown-item" type="submit" form="DLP" >
                                            <form method="POST" id="LIP" action="" style="Display:inline;">
                                                 <input type="hidden" name="deletepost" value="'.$post["username"].'"/>
                                                 <input type="hidden" name="postid" value="'.$post["pid"].'"/>
                                                 <button type="submit" style="color:black;text-decoration:none" class="card-link" name="submitdelete"/>Delete</button>
                                             </form>
                                        </a>
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
                        <a href="#" class="card-link" >
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
                <!-- Post /////--> 

                  <form method="POST" id="DLP" action="" style="Display:none;">
                     <input type="hidden" name="deletepost" value="'.$post["username"].'"/>
                     <input type="hidden" name="postid" value="'.$post["pid"].'"/>
                     <input type="submit" name="submitdelete"/>
                 </form>

                ';


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



