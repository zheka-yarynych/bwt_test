<?php 
class Controller_Login extends Controller
{
	function __construct(){
		$this->model = new Model_Login();
		$this->view = new View();
	}

	public function action_index()
	{
		if(isset($_POST['email']) && isset($_POST['password'])){
			$query = DB::$pdo->prepare("SELECT id, password FROM users WHERE email = ? LIMIT 1");
			$query->execute([$_POST['email']]);
			$res = $query->fetch();
			if($res->password == md5(md5($_POST['password']))){
				$hash = md5($res->password);
				$query = DB::$pdo->prepare("UPDATE users SET hash = ? WHERE id = ?");
				$query->execute([$hash, $res->id]);
				setcookie("id", $res->id, time()+60*60*24*30, "/");
				setcookie("hash", $hash, time()+60*60*24*30, "/");
				header('location: /');
		    }
		}



		$data = $this->model->get_data();
		$this->view->generate('login_view.php', 'template_view.php', $data);
	}
}
?>