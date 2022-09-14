<?php
 namespace Ecommerce\Core\Traits;

use PDO;

trait Dbh {


	protected function connect(){

		try {
		
			$dsn = "mysql:host=".host.";dbname=".db_name;
			$conn = new PDO($dsn,user,pass);
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