<?php   
include '../src/init.php';
include TPL_PATH.'header.inc.php';
include TPL_PATH.'navbar.inc.php';
?>


 
  
  <!-- 404 error section -->
  <section id="aa-error">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-error-area">
            <h2>404</h2>
            <span><?php echo $_SERVER['REQUEST_URI'];// Reflected XSS ?> Page Not Found</span> 
            <a href="index.php"> Go to Homepage</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / 404 error section -->


  
 <?php include TPL_PATH.'footer.inc.php' ;?>