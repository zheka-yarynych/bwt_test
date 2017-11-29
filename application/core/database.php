<?php 
class DB
{
	public static $pdo;

	public static function connect(){
		self::$pdo = new PDO("mysql:host=localhost;dbname=bwt_test; charset=UTF8", 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
																		   PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]);
	}
}

?>