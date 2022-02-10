<?php
session_start();
session_unset();
session_destroy();

 if(isset($_COOKIE['username'])) { 
          setcookie('fusername', '',time() - 3600 , '/');
          setcookie('fpassword','', time() - 3600 , '/');
    }  
   

//redirect to index.php

header("location:index.php");

?>