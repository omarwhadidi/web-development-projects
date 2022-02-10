<?php


// include '../includes/core/config.php';


class UpdateContr extends Update {


	private $FirstName;
	private $LastName;
	private $Username;
	private $Email;
	private $Password;
	private $Password2;
	private $ProfilePicture;
	private $token;


	public function __construct(){

		$this->token = bin2hex(random_bytes(50));   // generate a unique random token of length 100

	}


	public function SetUserData($FN,$LN,$UN,$EM,$PA,$PA2,$PP){

		$this->FirstName = $FN;
		$this->LastName = $LN;
		$this->Username = $UN;
		$this->Email = $EM;
		$this->Password = $PA;
		$this->Password2 = $PA2;
		$this->ProfilePicture = $PP;

	}


	// User Token Methods

	public function PrintToken(){

		return $this->token;
	}


	// User Data Validation Methods

	private function ValidateUser(){

		$result;

		if ( !preg_match('/^[A-Za-z][A-Za-z0-9]{3,31}$/', $this->Username) ) {

			$result = false;
		}
		else {
			$result = true;
		}

		return $result;

	}

	private function ValidateName(){

		$result;

		if ( !preg_match("/^[a-zA-Z-' ]*$/",$this->FirstName) || !preg_match("/^[a-zA-Z-' ]*$/",$this->LastName) ) {

			$result = false;
		}
		else {
			$result = true;
		}

		return $result;

	}

	private function ValidateEmail(){


		$result;

		if ( !filter_var($this->Email, FILTER_VALIDATE_EMAIL) ) {

			$result = false;
		}
		else {
			$result = true;
		}

		return $result;
		
	}

	private function ValidatePassword(){


		$result;

		if ( $this->Password !== $this->Password2  ) {

			$result = false;
		}
		else {
			$result = true;
		}

		return $result;
		
	}


	private function UploadPic(){

		$target_dir = "../uploads/";
		$target_file = $target_dir . basename($this->ProfilePicture["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		// Check if image file is a actual image or fake image
		  $check = getimagesize($this->ProfilePicture["tmp_name"]);
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
		if ($_FILES["fileToUpload"]["size"] > 500000) {
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
		} else {

			$image = rand(1 , 10000)."_".basename($this->ProfilePicture["name"]);
			$target_file = $target_dir . $image ;

		  if (move_uploaded_file($this->ProfilePicture["tmp_name"], $target_file)) {

		  		$target_dir = "uploads/";
				$target_file = $target_dir . $image ;
		    	
		    	return $this->UpdateProfilePic($target_file,$this->Username);


		  } else {
		    return "Sorry, there was an error uploading your file.";
		  }

		}

	}



	// Update Method

	public function UpdateUser(){


		if (!empty($this->FirstName)){

			if ($this->ValidateName() == false){

				$error = 'AlphaNumeric Characters Only Allowed in the name';
				return $error;
				exit();

			}
			else {
				
				$this->UpdateFirstName($this->FirstName,$this->Username);
				//echo 'FirstName Updated Successfully';
			}

		}

		if (!empty($this->LastName)){

			if ($this->ValidateName() == false){

				$error = 'AlphaNumeric Characters Only Allowed in the name';
				return $error;
				exit();

			}
			else {

				$this->UpdateLastName($this->LastName,$this->Username);
				//echo 'LastName Updated Successfully';
			}

		}


		if (!empty($this->Email)){

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
				
				$this->UpdateEmail($this->Email,$this->Username);
				//echo 'Email Updated Successfully';
			}

		}

		if (!empty($this->Password)){

			if ($this->ValidatePassword() == false){

				$error = "Passwords Don't Match";
				return $error;
				exit();
			}
			else {
				$this->UpdatePassword($this->Password,$this->Username);
				//echo 'Password Updated Successfully';
			}
			
		}

		if(!empty($this->ProfilePicture['tmp_name'])){

			$error = $this->UploadPic();

			if ($error != 1){

				return $error;
				exit();
			}

          
        }

		/*		if (!empty($this->Username)){

			if ($this->CheckUser($this->Username) == true){

				$error = "Username Already Exists";
				return $error;
				exit();

			}
			elseif ($this->ValidateUser() == false){

				$error = 'AlphaNumeric Characters Only Allowed in the username and min 4 chars';
				return $error;
				exit();

			}
			else {
				echo 'Username Updated Successfully';
			}

		}*/
		
		return 'Form Updated Successfully';
		
		  		
	}

	
	

}





?>




