<?php 
class Controller_Main extends Controller
{
	function __construct(){
		$this->model = new Model_Main();
		$this->view = new View();
	}

	function action_index()
	{	
		User_Data::only('user');
		$data = $this->model->get_data();
		$this->view->generate('main_view.php', 'template_view.php', $data);
	}
}

?>