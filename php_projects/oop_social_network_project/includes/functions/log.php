<?php

	function logmessage($filename,$logmessage){
		
		$fn='logs/'.$filename;   # The log file
		$fh=fopen($fn,'a');   # Open log file in append mode
		fwrite($fh,$logmessage."\n"); # Append the log Message
		fclose($fh);  # close the file
	}

?>