<?php
require 'includes/core/config.php';
include 'classes/dbh.classes.php';
include 'classes/session.classes.php';
include 'classes/model/user.classes.php';
include 'classes/controller/user-contr.classes.php';


$user = new UserContr();

if (isset($_REQUEST['searchuser']) && !empty($_REQUEST['searchuser'])  ){

    $usern = escape($_REQUEST['searchuser']);
    $searchresult = $user->GetUsername($usern);
    echo '';
    if (is_array($searchresult)){
        foreach ($searchresult as $userdata){

          echo '<p><img class="rounded-circle" width="45" src="'.$userdata['profile_pic'].'" > 
          '.$userdata['firstname'].' '.$userdata['lastname'].'</p>';  

        }
    }
    

}

?>