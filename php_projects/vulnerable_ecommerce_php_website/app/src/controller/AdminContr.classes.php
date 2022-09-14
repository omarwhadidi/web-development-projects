<?php
namespace Ecommerce\Controller\Admin; 
use Ecommerce\Model\Admin\Admin;

use Ecommerce\Core\Traits\Validation; 


class AdminContr extends Admin {

	use Validation;

	Public function GetUserDetails($username){

		return $this->GetUserInfo($username);

	}

	// Users Methods


	// Products Methods

	public function AddProduct($p_name,$category,$product_details,$qty,$price,$seller_name,$p_image,$p_status){

		if (empty($p_name) == True || empty($category) == True || empty($product_details) == True  || empty($qty) == True || empty($price) == True || empty($seller_name) == True || empty($p_status) == True || empty($p_image['tmp_name']) == True){
			
			return 'All Fields are Required';
			exit();
		}

		$target_dir = "../assets/uploads/products/";
		$target_file = $target_dir . basename($p_image["name"]);
		if (!$this->UploadProductImage($p_image)) {

			return 'coudnt upload Product image';
			exit();

		}

		$Result = $this->InsertProduct($p_name,$category,$product_details,$qty,$price,$seller_name,$target_file,$p_status);

		if ($Result !== True){

			return 'Not Inserted';
			exit();
		}

		return True;
	}

	private function UploadProductImage($p_image){

		$target_dir = "../assets/uploads/products/";
		$target_file = $target_dir . basename($p_image["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		// Check if image file is a actual image or fake image
		$check = getimagesize($p_image["tmp_name"]);
		if($check !== false) {
		    
		    $uploadOk = 1;

		} else {
		    $error = "File is not an image.";
		    $uploadOk = 0;
		}
		

		// Check if file already exists
		if (file_exists($target_file)) {
		  $error = "file already exists.";
		  $uploadOk = 0;
		}

		// Check file size
		if ($p_image["size"] > 500000) {
		  $error = " your file is too large.";
		  $uploadOk = 0;
		}

		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		  $error =  " only JPG, JPEG, PNG & GIF files are allowed.";
		  $uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			return "Sorry, your file was not uploaded, ".$error;
			// if everything is ok, try to upload file
		} 
		else {

			$image = rand(1 , 10000)."_".basename($p_image["name"]);
			$target_file = $target_dir . $image ;

		    if (move_uploaded_file($p_image["tmp_name"], $target_file)) {
		    	
		    	return True;

		    } 
		    else {
		  		return "Sorry, there was an error uploading your file.";
		    }

		}

	}

	// Orders Methods




}



?>