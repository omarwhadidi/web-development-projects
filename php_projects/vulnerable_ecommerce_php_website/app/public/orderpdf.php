<?php
ob_start();    // Fix Headers Already Sent Error (First Thing in the Page)
session_start();

if (!isset($_POST['order_id'])){

  header("Location: index.php");
  exit();
}

################################################################################################
################################################################################################
#########  There are few PHP libraries capable of parsing HTML/CSS and transforming that to PDF:
#########    - mPDF
#########    - TCPDF (will be replaced some day by tc-lib-pdf)
#########    - Dompdf
#########    - wkhtmltopdf : https://github.com/wkhtmltopdf/wkhtmltopdf
######### 	 - Phantomjs 
#########    - typeset.sh (paid)
#########  Resources
######### 		 - https://ourcodeworld.com/articles/
#########          read/226/top-5-best-open-source-pdf-generation-libraries-for-php
#########  Install mpdf
#########    - Install Composer & Add it to PATH ENV
#########    - composer require mpdf/mpdf 
################################################################################################
################################################################################################
require __DIR__.'/includes/libraries/mpdf/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf();


require '../src/init.php';


use Ecommerce\Controller\Auth As Auth;
use Ecommerce\Controller\User As User;
use Ecommerce\Controller\Product As Product;

$Auth = new Auth\LoginContr();
$Product = new Product\ProductContr();
$Customer = new User\CustomerContr();

$Auth->ValidateUserSession();

if(isset($_SESSION['loggedin'])){
    $UserSession = $_SESSION['username'];
    $UserDetails = $Customer->GetUserDetails($UserSession); 

}


$OrderId =  $_POST['order_id'];
//$OrderDetails = $Customer->CheckUserOrder($OrderId,$UserSession);  // Prevent IDOR
$OrderDetails = $Customer->ReturnOrderByID($OrderId);

if ($OrderDetails === False){

	$Data  ="<h1> Order Not Found</h1>";
	//$Data  ="<h1>Unauthorized Access</h1>";
	$mpdf->WriteHTML($Data);
	$mpdf->Output('order.pdf','D');
	exit();

}

$Data  ="<h1>Your Order Details</h1>";
$Data .="<h3>Order ID: ".escape_output($OrderDetails['order_id'])."  </h3>";
$Data .="<h3>Order Date: ".escape_output($OrderDetails['order_date'])." </h3>";
$Data .="<h3>Shipping Address: ".escape_output($OrderDetails['address'])."  </h3>";
$Data .="<h3>Phone Number: ".escape_output($OrderDetails['phone'])."  </h3>";
$Data .="<h3>Full Name: ".escape_output($OrderDetails['name'])."  </h3>";
$Data .="<h3>Amont Paid $".escape_output($OrderDetails['paid_amount'])." </h3>";
$Data .="<h3>Products</h3>";
$Data .="<ol>";

$UserProducts = json_decode($OrderDetails['products'],true) ;
foreach ($UserProducts as $UserProduct) {
  $Data .="<li>". escape_output($UserProduct['name']) .' * '.escape_output($UserProduct['qty']).'<li>';
}
$Data .="</ol>";

$mpdf->WriteHTML($Data);
$mpdf->Output('order.pdf','D');
?>