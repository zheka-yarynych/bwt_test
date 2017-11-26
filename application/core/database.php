<?php 
class DB
{
	public static function connect(){
		$db = new PDO("mysql:host=localhost;dbname=bwt_test", 'root', '');
        $db->exec("set names utf8");
	}
}

?>