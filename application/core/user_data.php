<?php 
class User_Data
{
	public static function get_user($id)
	{
		if (!empty($id))
		{
			$query = DB::$pdo->prepare("SELECT id, hash, name, lastname, bday, email, sex FROM users WHERE id = ?");
			$query->execute([$id]);
			$res = $query->fetch();
			if(!is_null($res) && $res->hash == $_COOKIE['hash'])return $res;
			else {
				setcookie("id", '');
				setcookie("hash", '');
				return false;
			}
		}
		else return false;
	}

	public static function only($filter)
	{
		if($filter == 'user'){
			if(!self::get_user($_COOKIE['id']) && $_SERVER['REQUEST_URI'] != '/login' && $_SERVER['REQUEST_URI'] != '/register')
				header('location: /login');
		}
		elseif($filter == 'quest'){
			if(self::get_user($_COOKIE['id']) && ($_SERVER['REQUEST_URI'] == '/login' || $_SERVER['REQUEST_URI'] == '/register'))
				header('location: /');
		}
	}
}
?>