<?php 
include '../src/init.php';
include TPL_PATH.'header.inc.php';
include TPL_PATH.'navbar.inc.php';



if (isset($_GET['id'])){

    $productID =  $_GET['id'];
} else {

    $productID = 1;
}


$ProductDetails = $Product->GetProductDetails($productID);


if (isset($_POST['comment']) && !empty($_POST['review'])){

    $UserReview = $_POST['review'];

    if(strpos($_SERVER['HTTP_REFERER'], 'http://localhost') !== false) {  // CSRF Bad Regex in Referer Check  
      
      $Customer->HandleUserReview($UserReview, $UserSession,$productID);

    }
    else {
      header('HTTP/1.1 403 Forbidden');
      exit('Forbidden');
    }

    
}


?>

 
  <!-- catg header banner section -->
  <section id="aa-catg-head-banner">
   <img src="assets/img/fashion/fashion-header-bg-8.jpg" alt="fashion img">
   <div class="aa-catg-head-banner-area">
     <div class="container">
      <div class="aa-catg-head-banner-content">
        <h2>T-Shirt</h2>
        <ol class="breadcrumb">
          <li><a href="index.php">Home</a></li>         
          <li><a href="#">Product</a></li>
          <li class="active">T-shirt</li>
        </ol>
      </div>
     </div>
   </div>
  </section>
  <!-- / catg header banner section -->

  <!-- product category -->
  <section id="aa-product-details">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-product-details-area">
            <div class="aa-product-details-content">
              <div class="row">
                <!-- Modal view slider -->
                <div class="col-md-5 col-sm-5 col-xs-12">                              
                  <div class="aa-product-view-slider">                                
                    <div id="demo-1" class="simpleLens-gallery-container">
                      <div class="simpleLens-container">
                        <div class="simpleLens-big-image-container"><a data-lens-image="img/view-slider/large/polo-shirt-1.png" class="simpleLens-lens-image"><img src="assets/img/view-slider/medium/polo-shirt-1.png" class="simpleLens-big-image"></a></div>
                      </div>
                      <div class="simpleLens-thumbnails-container">
                          <a data-big-image="img/view-slider/medium/polo-shirt-1.png" data-lens-image="img/view-slider/large/polo-shirt-1.png" class="simpleLens-thumbnail-wrapper" href="#">
                            <img src="assets/img/view-slider/thumbnail/polo-shirt-1.png">
                          </a>                                    
                          <a data-big-image="img/view-slider/medium/polo-shirt-3.png" data-lens-image="img/view-slider/large/polo-shirt-3.png" class="simpleLens-thumbnail-wrapper" href="#">
                            <img src="assets/img/view-slider/thumbnail/polo-shirt-3.png">
                          </a>
                          <a data-big-image="img/view-slider/medium/polo-shirt-4.png" data-lens-image="img/view-slider/large/polo-shirt-4.png" class="simpleLens-thumbnail-wrapper" href="#">
                            <img src="assets/img/view-slider/thumbnail/polo-shirt-4.png">
                          </a>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal view content -->
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <div class="aa-product-view-content">
                    <h3><?php echo $ProductDetails['product_name'] ;?></h3>
                    <div class="aa-price-block">
                      <span class="aa-product-view-price">$ <?php echo $ProductDetails['price'] ;?></span>
                      <p class="aa-product-avilability">Avilability: <span><?php 
                      $pid = $ProductDetails['product_id'];
                      echo $Product->CheckInStock($pid);
                       ?></span></p>
                    </div>
                    <p><?php echo $ProductDetails['product_details'] ;?></p>
                    <h4>Size</h4>
                    <div class="aa-prod-view-size">
                      <a href="#">S</a>
                      <a href="#">M</a>
                      <a href="#">L</a>
                      <a href="#">XL</a>
                    </div>
                    <h4>Color</h4>
                    <div class="aa-color-tag">
                      <a href="#" class="aa-color-green"></a>
                      <a href="#" class="aa-color-yellow"></a>
                      <a href="#" class="aa-color-pink"></a>                      
                      <a href="#" class="aa-color-black"></a>
                      <a href="#" class="aa-color-white"></a>                      
                    </div>
                    <div class="aa-prod-quantity">
                      <form action="">
                        <select id="" name="">
                          <option selected="1" value="0">1</option>
                          <option value="1">2</option>
                          <option value="2">3</option>
                          <option value="3">4</option>
                          <option value="4">5</option>
                          <option value="5">6</option>
                        </select>
                      </form>
                      <p class="aa-prod-category">
                        Category: <a href="#">Polo T-Shirt</a>
                      </p>
                    </div>
                    <div class="aa-prod-view-bottom">
                      <form   method="POST">
                        <input type="hidden" name="pid" value="<?php echo $pid; ?>"  />
                        <button class="aa-add-to-cart-btn" type="submit" name="addtocart">Add To Cart</button>
                        <button class="aa-add-to-cart-btn" href="#">Wishlist</button>
                      </form>
                    </div>
                    <?php if (isset($AddToCartResult)){echo '<div class= "alert alert-danger" style="margin-top:80px;" >'.$AddToCartResult.'</div>';} ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="aa-product-details-bottom">
              <ul class="nav nav-tabs" id="myTab2">
                <li><a href="#description" data-toggle="tab">Description</a></li>
                <li><a href="#review" data-toggle="tab">Reviews</a></li>                
              </ul>

              <!-- Tab panes -->
              <div class="tab-content">
                <div class="tab-pane fade in active" id="description">
                  <p><?php echo $ProductDetails['product_details'] ;?></p>
                </div>
                <div class="tab-pane fade " id="review">
                 <div class="aa-product-review-area">
                   <h4> Reviews for T-Shirt</h4> 
                   <ul class="aa-review-nav">
                    <?php 

                      $Reviews = $Customer->ReturnReviewsByID($productID);

                      foreach ($Reviews as $Review ){
                        // Prevent Stored XSS escape_output($Review['review'])
                        echo '
                             <li>
                            <div class="media">
                              <div class="media-left">
                                <a href="#">
                                  <img class="media-object" src="img/testimonial-img-3.jpg" alt="girl image">
                                </a>
                              </div>
                              <div class="media-body">
                                <h4 class="media-heading"><strong>'.escape_output($Review['username']).'</strong> - <span>'.$Review['review_date'].'</span></h4>
                                <div class="aa-product-rating">
                                  <span class="fa fa-star"></span>
                                  <span class="fa fa-star"></span>
                                  <span class="fa fa-star"></span>
                                  <span class="fa fa-star"></span>
                                  <span class="fa fa-star-o"></span>
                                </div>
                                <p>'.$Review['review'].'.</p>
                              </div>
                            </div>
                          </li>


                        ';

                      }



                    ?>
                    
                   </ul>
                  <?php if(isset($_SESSION['loggedin'])){  ?>    
                   <h4>Add a review</h4>
                   <div class="aa-your-rating">
                     <p>Your Rating</p>
                     <a href="#"><span class="fa fa-star-o"></span></a>
                     <a href="#"><span class="fa fa-star-o"></span></a>
                     <a href="#"><span class="fa fa-star-o"></span></a>
                     <a href="#"><span class="fa fa-star-o"></span></a>
                     <a href="#"><span class="fa fa-star-o"></span></a>
                   </div>
                   <!-- review form -->
                   <form class="aa-review-form" action="" method="POST">
                      <div class="form-group">
                        <label for="message">Your Review</label>
                        <textarea class="form-control" rows="3" id="message" name="review"></textarea>
                      </div>
<!--                       <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Name">
                      </div>  
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="example@gmail.com">
                      </div> -->

                      <button type="submit" class="btn btn-default aa-review-submit" name="comment">Submit</button>
                   </form>
                   <?php }?>
                 </div>
                </div>            
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / product category -->


 <?php include TPL_PATH.'footer.inc.php' ;?>