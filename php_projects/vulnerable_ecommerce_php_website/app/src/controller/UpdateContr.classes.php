<?php
namespace Ecommerce\Controller\User; 
use Ecommerce\Model\User\Update;

use Ecommerce\Core\Traits\Validation; 

class UpdateContr extends Update {

	use Validation;

	Private $SessionUser;
	Private $FullName;
	Private $Username;
	Private $Password;
	Private $ConfirmPassword;
	Private $Gender;
	Private $ProfilePicture;
	Private $MFA;
	Private $ClientIp;
	Private $ClientUseragent;
	Private $token;

	Public function __construct($SessionUser,$FullName,$Username,$Password,$ConfirmPassword,$Gender,$MFA,$ProfilePicture,$ClientIp,$ClientUseragent){

		$this->SessionUser 		= $SessionUser;
		$this->FullName 		= $FullName;
		$this->Username 		= $Username;
		$this->Password 		= $Password;
		$this->ConfirmPassword  = $ConfirmPassword;
		$this->Gender 			= $Gender;
		$this->MFA 				= $MFA;
		$this->ProfilePicture   = $ProfilePicture;
		$this->ClientIp 		= $ClientIp;
		$this->ClientUseragent  = $ClientUseragent; 
		
	}


	Public function UpdateUser(){

		if (!empty($this->FullName)){

			if ($this->ValidateName($this->FullName) == False){

				$error = 'AlphaNumeric Characters Only Allowed in the name';
				return $error;
				exit();

			}
			else {
				
				$this->UpdateFullName($this->FullName,$this->SessionUser);
				//echo 'Name Updated Successfully';
			}

		}

        /*if (!empty($this->Email)){

			if ($this->ValidateEmail() == false){

				$error = 'Invalid Email';
				return $error;
				exit();
			}
			elseif ($this->CheckEmail($this->Email) == true){

				$error = " Email Already Exists";
				return $error;
				exit();
			}

			else {
				
				$this->UpdateEmail($this->Email,$this->SessionUser);
				//echo 'Email Updated Successfully';
			}

		}*/

		if (!empty($this->Password)){

			if ($this->MatchPassword($this->Password,$this->ConfirmPassword) == False){

				$error = "Passwords Don't Match";
				return $error;
				exit();
			}
			elseif ($this->PasswordPolicy($this->Password) == False){

				$error = "Passwords is too weak";
				return $error;
				exit();
			}
			else {
				$this->UpdatePassword($this->Password,$this->SessionUser);
				//echo 'Password Updated Successfully';
			}
			
		}

		if (!empty($this->Gender)){

			if ($this->ValidateGender() == False){

				$error = 'Please Use a Valid Gender';
				return $error;
				exit();

			}
			else {
				
				$this->UpdateGender($this->Gender,$this->SessionUser);
				//echo 'Name Updated Successfully';
			}

		}


        if (!empty($this->MFA)){

			$this->Update2FA($this->MFA,$this->SessionUser);

		}

		if(!empty($this->ProfilePicture['tmp_name'])){

			$error = $this->UploadPic();

			if ($error != 1){

				return $error;
				exit();
			}
        
        }


        if (!empty($this->Username)){

			if ($this->CheckUserDB($this->Username) == true){

				$error = "Username Already Exists";
				return $error;
				exit();

			}
			elseif ($this->ValidateUsername($this->Username) == False){

				$error = 'AlphaNumeric Characters Only Allowed in the username && min 4 chars';
				return $error;
				exit();

			}
			else {
				$this->UpdateUsername($this->Username,$this->SessionUser);
				
				//echo 'Email Updated Successfully';
			}
		}
		
		return 'Form Updated Successfully';
			  		
	}

	Private function UploadPic(){

		$target_dir = "../public/assets/uploads/users/";
		$target_file = $target_dir . basename($this->ProfilePicture["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		// Check if image file is a actual image or fake image
/*		$check = getimagesize($this->ProfilePicture["tmp_name"]);
		if($check !== false) {
		    
		    $uploadOk = 1;

		} else {
		    $error = "File is not an image.";
		    $uploadOk = 0;
		}*/
		

		// Check if file already exists
		if (file_exists($target_file)) {
		  $error = "file already exists.";
		  $uploadOk = 0;
		}

		// Check file size
		if ($this->ProfilePicture["size"] > 5000000) {
		  $error = " your file is too large.";
		  $uploadOk = 0;
		}

		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" && $imageFileType != "svg" ) {
		  $error =  " only JPG, JPEG, PNG , SVG & GIF files are allowed.";  // XSS in SVG
		  $uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			return "Sorry, your file was not uploaded, ".$error;
			// if everything is ok, try to upload file
		} 
		else {

			$image = rand(1 , 10000)."_".basename($this->ProfilePicture["name"]);
			//$image = $this->ProfilePicture["name"]; // XSS via Filename
			$target_file = $target_dir . $image ;

		    if (move_uploaded_file($this->ProfilePicture["tmp_name"], $target_file)) {
		    	
		    	return $this->UpdateProfilePic($target_file,$this->SessionUser);

		    } 
		    else {
		  		return "Sorry, there was an error uploading your file.";
		    }

		}

	}

	Private function ValidateGender(){

		if ($this->Gender == 'Male' || $this->Gender == 'Female'){

			return 1;
		}
		else {
			return 0;
		}

	}

}

?>
