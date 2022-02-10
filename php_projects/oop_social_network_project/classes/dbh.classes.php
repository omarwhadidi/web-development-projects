<?php
 

class Dbh {

 	const servername = 'localhost';
 	const username = 'pentest';
 	const password = 'pentest';
 	const dbname = 'ooppentest';



	protected function connect(){

		try {
		
			$dsn = "mysql:host=".self::servername.";dbname=".self::dbname;
			$conn = new PDO($dsn, self::username , self::password);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			return $conn;
			
		
		} 
		catch(PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
		}

	}


}
 

?>