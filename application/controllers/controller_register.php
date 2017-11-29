<?php 
class Controller_Register extends Controller
{
	function __construct()
	{
		$this->model = new Model_Register();
		$this->view = new View();
	}

	public function action_index()
	{
		User_Data::only('quest');
		
		if ($_POST)
		{
			$form_data = ['name' => $_POST['name'],
			 			  'lastname' => $_POST['lastname'],
						  'email' => $_POST['email'],
						  'password' => $_POST['password'],
						  'pass2' => $_POST['pass2']];

			$error = $this->errors($form_data);
			if ($error == -1)
			{
				$form_data['password'] = md5(md5(trim($form_data['password'])));
				$query = DB::$pdo->prepare("INSERT INTO users SET name = ?, lastname = ?, email = ?, password = ?");
				$query->execute([$form_data['name'], $form_data['lastname'], $form_data['email'], $form_data['password']]);
				$hash = md5($form_data['password']);
				$id = DB::$pdo->lastInsertId();
				$updQuery = DB::$pdo->prepare("UPDATE users SET hash = ? WHERE id = ?");
		        $updQuery->execute([$hash, $id]);
		        setcookie("id", $id, time()+60*60*24*30, "/");
		        setcookie("hash", $hash, time()+60*60*24*30, "/");
		        header('location: /');
			}
			else echo $error;
		}

		$data = $this->model->get_data();
		$this->view->generate('register_view.php', 'template_view.php', $data);
	}

	public function errors($arr=[])
	{
		$res = -1;
		$val_data = [
					  'name' => 'именем',
					  'lastname' => 'фамилией',
					  'email' => 'email\'ом',
					  'password' => 'паролем',
					  'pass2' => 'повторным паролем'
					 ];
	
		foreach ($arr as $key => $value)
		{
			if(empty($value))
			{
				$res = "Заполните поле с ".$val_data[$key];
				break;
			}
		}

		if ($res == -1) {
			if(!preg_match("/^[-a-zа-я]+$/ui", $arr['name']))$res = "Имя может состоять только из букв русского/латынского алфавита и знака \"-\"";
			if(!preg_match("/^[-a-zа-я]+$/ui", $arr['lastname']))$res = "Фамилия может состоять только из букв русского/латынского алфавита и знака \"-\"";
			if(!preg_match("/^[-0-9a-z\.\@\_]+$/ui", $arr['email']))$res = "Не корректный Email";
			if(strlen($arr['name'])>32)$res = "Превишен лимит 32 символа в поле с именем";
			if(strlen($arr['lastname'])>32)$res = "Превишен лимит 32 символа в поле с фамилией";
			if(strlen($arr['email'])>64)$res = "Превишен лимит 64 символа в поле с Email'ом";
			if(strlen($arr['password'])>32 || strlen($arr['pass2'])>32)$res = "Превишен лимит 32 символа в поле с паролем";
			if($arr['password'] != $arr['pass2'])$res = "Пароли не совпадают";
		}
		if ($res == -1){
			$query = DB::$pdo->prepare('SELECT COUNT(id) FROM users WHERE email = ?');
			$query->execute([$arr['email']]);
			$qres = $query->fetchColumn();
			if($qres > 0)$res = "Пользователь с таким Email'ом уже зарегистрирован";
		}

		return $res;
	}
}
?>