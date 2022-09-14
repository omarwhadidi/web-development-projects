<?php 

// Import PHPMailer classes into the global namespace 
	use PHPMailer\PHPMailer\PHPMailer; 
	use PHPMailer\PHPMailer\Exception; 

/*
filter_var($comment, FILTER_SANITIZE_STRING);

filter_var($url, FILTER_VALIDATE_URL)
filter_var($url, FILTER_SANITIZE_URL)
filter_var($ip, FILTER_VALIDATE_IP)
*/

function redirect($location , $ErrorMsg , $sec=3){

	if (isset($error)){
		echo '<div class="alert alert-danger">'.$ErrorMsg.'</div>';
		header('refresh:$sec;url=$location');
	}
	else {

		header('Location: '.$location);
		exit();
	}
}

function Generate_Token(){

	return bin2hex(random_bytes(100));   // generate a unique random token of length 100

}

function log_actions($filename,$Clientip,$useragent,$log){
		
		$fn='../var/logs/'.$filename;   # The log file
		$fh=fopen($fn,'a');   # Open log file in append mode

		$logmessage = "[".date("l jS \of F Y h:i:s A")."] - [ IP: ".$Clientip." ] - [ From : ".$useragent." ] - [ ".$log ."]";

		fwrite($fh,$logmessage."\n"); # Append the log Message
		fclose($fh);  # close the file

}

function escape_output($data){

	$output = $data;
	$output = htmlspecialchars($output, ENT_QUOTES, 'UTF-8'); # convert special characters to HTML format {/>&&<"}
	# $output = htmlspecialchars($output, ENT_QUOTES, 'UTF-8'); # convert all characters to HTML string
	$output = stripslashes($output);  # Put a backslashe before  single quotes ('), double quotation marks ("), backslashes (\), and NUL (the NULL character).
	return $output;

}

function SendEmail($email,$msg,$sub){
	 
	 
	$mail = new PHPMailer; 
	 
	$mail->isSMTP();                      // Set mailer to use SMTP 
	$mail->Host = 'smtp.gmail.com';       // Specify main and backup SMTP servers 
	$mail->SMTPAuth = true;               // Enable SMTP authentication 
	$mail->Username = 'omarwhadidi9@gmail.com';   // SMTP username 
	$mail->Password = 'ocrqutdvmjdciapq';   // SMTP password 
	$mail->SMTPSecure = 'tls';            // Enable TLS encryption, `ssl` also accepted 
	$mail->Port = 587;                    // TCP port to connect to 
	 
	// Sender info 
	$mail->setFrom('omarwhadidi9@gmail.com', 'Ecommerce'); 
	//$mail->addReplyTo('reply@codexworld.com', 'CodexWorld'); 
	 
	// Add a recipient 
	$mail->addAddress($email); 
	 
	//$mail->addCC('cc@example.com'); 
	//$mail->addBCC('bcc@example.com'); 
	 
	// Set email format to HTML 
	$mail->isHTML(true); 
	 
	// Mail subject 
	$mail->Subject = $sub; 
	 


	$mail->Body    = $msg; 


	// Add attachments
	//$mail->addAttachment('/var/tmp/file.tar.gz');
	//$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name
	 
	// Send email 
	if(!$mail->send()) { 
		$msg =  'Message could not be sent. Mailer Error: '.$mail->ErrorInfo; 
		return $msg;
	}
	else { 
	    return True;

	} 
	 
}



?>