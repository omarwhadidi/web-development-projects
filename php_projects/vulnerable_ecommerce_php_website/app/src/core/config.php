<?php


// src/core/config.php

// Database 
define('host' ,'mysqldb');
define('user' ,'root');
define('pass' ,'root');
define('db_name' ,'ecommerce');

// Path
define('ROOT_DIR' ,'C:\xampp\htdocs\localhost/ecommerce/public/');
define('CSS' , 'assets/css/');
define('JS'  , 'assets/js/');
define('IMG' , 'assets/img/');
define('TPL_PATH' , 'includes/templates/');






/*$config = [
	'database' => [
		'hostname' => 'localhost',
		'port' => 3306 ,
		'User' => 'root',
		'Pass' => 'root',
		'db_name' => 'ecommerce',
	],
	'website' => [
		'Name' => 'Ecommerce',
		'SiteTitle' => 'ecomm',
		'Debug' => 0,
		'Production' => '0',
		'root_dir' => '' 
	]


];*/






/*   

 * Defining Config.php Using Other Methods
	
	|---------------------------------------------------------------------------
    | 	
    |	1-  Define Config File using variables   (not prefarable)
	| 		** Config.php 
	|			# DB Variables
	|			$db_host = 'localhost';
	|			$db_name = 'somedb';
	|			$db_user = 'someuser';
	|			$db_pass = 'somepass';
	|
	|		** Include : (the variables are referenced as globals)
	|			include('config.php');
	|			echo $db_host; // 'localhost'
	|
	|---------------------------------------------------------------------------
	|---------------------------------------------------------------------------
	|	
	|	2-  Define Config File using Constants (not prefarable)
	|		** config.php
	|			# DB consts
	|			define('DB_NAME', 'test');
	|			define('DB_USER', 'root');
	|			define('DB_PASSWORD', '');
	|			define('DB_HOST', 'localhost');
	|			
	|			# Site Consts
	|			define('TITLE', 'sitetitle');
	|			define('DEBUG',0);
	|
	|		** Include
	|			include('config.php');
	|			echo DB_HOST; // 'localhost'
	|
	|---------------------------------------------------------------------------	|---------------------------------------------------------------------------
	|	
	|	3-  Define Config File using Arrays (prefarable way to define config file)
	|		
	|		** Method 1:
	|	
	|			*** Config.php         # we can assign it to a var $db = array();
	|				return array(
	|				 'hostname' => 'localhost',
	|				 'username' => 'root',
	|				 'password' => 'root',
	|				 'db_name' => 'Ecommerce'
	|				);
	|			
	|			*** Config.php
	|				return [
	|				  'host' => 'localhost',
	|				  'name' => 'somedb',
	|				  'user' => 'someuser',
	|				  'pass' => 'somepass'
	|				];
	|			
	|			*** Include: 
	|					$conf = include('config.php');  
	|					$hostname = $conf['hostname'];  // 'localhost'
	|					$username = $conf['username'];  // 'root'
	|
	|		** Method 2:  (Multidimensional array)
	|			
	|			*** Config.php
	|				return [
	|			  		'database' => [
	|			    		'host' => 'localhost',
	|			    		'name' => 'somedb',
	|			    		'user' => 'someuser',
	|			    		'pass' => 'somepass'
	|			 		 ],
	|			  		'other-stuff' => ... ,
	|			  		'php-settings'=> [
	|			   			'DEBUG' => 0,
	|			    		'Environment' => 'Production'
	|				  	]
	|				];
	|
	|
	|			*** Config.php
	|				return array(
	|					'phpSettings' => array(
	|			        	'display_startup_errors' => 1,
	|			        	'display_errors'         => 1,
	|			        	'error_reporting'        => (E_ALL | E_STRICT)
	|		   		 	),
	|		   		 	'db'  => array(
	|	                	'host'     => 'localhost',
	|	                	'username' => 'foo',
	|	                	'password' => 'bar',
	|	                	'dbname'   => 'baz'
    |      				 )
	|				);
	|
	|			*** Include: 
	|					$conf = include('config.php');  
	|					$hostname = $conf['db']['hostname'];  // 'localhost'
	|					$username = $conf['db']['username'];  // 'root'
	|
	|---------------------------------------------------------------------------	|---------------------------------------------------------------------------
	|	
	|	4-  Define Config File using objects
	|	
	|		** config.php
	|				
	|			return (object) array(
	|		    	'host' => 'localhost',
	|		    	'username' => 'root',
	|		    	'pass' => 'password',
	|		    	'database' => 'db',
	|		    	'app_info' => array(
	|		        	'appName'=>"App Name",
	|		        	'appURL'=> "http://yourURL/#/"
	|		    	)
	|			);
	|			
	|		** Include :
	|
	|			This allows you to use the object syntax when you include the php : 
	|           $configs->host instead of  $configs['host'].
	|				include 'config.php';
	|					$hostname = $conf->hostname;
	|					$username = $conf->username;
	|
	|---------------------------------------------------------------------------	|---------------------------------------------------------------------------
	|	5- Define Config File as a Class
	|		
	|		** config.php
	|			class Config {
	|			
	|		    	static $dbHost = 'localhost';
	|		    	static $dbUsername = 'user';
	|		    	static $dbPassword  = 'pass';
	|
	|		    	public static function getInstance()
    |				{
    | 					.... 
	|				}
	|
	|		** Include
	|			then you can simple use it:
	|
	|				Config::$dbHost 
	|				Config::getInstance()
	|
	|---------------------------------------------------------------------------	|---------------------------------------------------------------------------
	|	6- Define Config File as a config.ini
	|		
	|		** config.ini
	|		 	create a file config.ini Then, write your configurations in it. 
	|				
	|				[database]
	|				hostname = 'localhost'
	|				username = 'root'
	|				password = 'pass1234'
	|				db = 'my_db'
	|		
	|		** Include
	|			Next, create an index.php file and create an $ini variable in it.
	|
	|				$ini = parse_ini_file('config.ini');
	|
	|				$hostname = $ini['hostname'];
	|				$username = $ini['username'];
	|
	|---------------------------------------------------------------------------	|---------------------------------------------------------------------------

*/




?>
