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
				//тут будет регистрация;
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
		return $res;
	}
}
?>