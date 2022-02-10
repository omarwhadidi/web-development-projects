<?php
	
	function escape($string){

		$string = htmlentities($string , ENT_QUOTES , 'UTF-8');
		$string = stripslashes($string);
		return $string;
	}

?>