<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'login_profile');

define('PROJECT_NAME', 'Film Databasen');
define('PROJECT_EMAIL', 'Support@FilmBasen.dk');
define('PROJECT_URL', '//www.film-databasen.dk');

class DB_con {
	public $connection;
	function __construct(){
		$this->connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD,DB_DATABASE);
		if ($this->connection->connect_error) die('Database error -> ' . $this->connection->connect_error);		
	}
	
	function ret_obj(){
		return $this->connection;
	}
}

$mysqli = new DB_con();
$mysqli = $mysqli->ret_obj();
if ($mysqli->connect_errno) {
    echo "Error: " . $mysqli->connect_error . "\n";
    exit;
}