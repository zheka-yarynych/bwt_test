<?php 
class User_Data
{
	public static function exists_user($id)
	{
		if (!empty($id))
		{
			$query = DB::$pdo->prepare("SELECT id, hash FROM users WHERE id = ?");
			$query->execute([$id]);
			$res = $query->fetch();
			return (!is_null($res) && $res->hash == $_COOKIE['hash']) ? true : false;
		}
		else return false;
	}
}
?>