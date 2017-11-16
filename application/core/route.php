<?php 

class Route
{
	public function start()
	{
		//Изначальная страница
		$controller_name = "Main";
		$action_name = "index";

		//Разбиваем ссылку на массив(для определения экшена, контроллера)
		$routes = explode('/', $_SERVER['REQUEST_URI']);

		//Получаем контроллер, если он есть
		if (!empty($routes[1]) )
		{	
			$controller_name = $routes[1];
		} 

		//Получаем экшен
		if (!empty($routes[2]) )
		{
			$action_name = $routes[2];
		}

		//Добавляем префиксы
		$model_name = 'Model_'.$controller_name;
		$controller_name = 'Controller_'.$controller_name;
		$action_name = 'action_'.$action_name;

		//Подключаем модель на основе полученных данных
		$model_file = strtolower($model_name).'.php';
		$model_path = "application/models/".$model_file;
		if(file_exists($model_path))
		{
			include "application/models/".$model_file;
		}

		//Подключаем контроллер
		$controller_file = strtolower($controller_name).'.php';
		$controller_path = "application/controllers/".$controller_file;
		if(file_exists($controller_path))
		{
			include "application/controllers/".$controller_file;
		}
		else
		{
			Route::ErrPg404();
		}
		
		//Создаем контроллер
		$controller = new $controller_name;
		$action = $action_name;
		
		if(method_exists($controller, $action))
		{
			//Вызываем действие контроллера
			$controller->$action();
		}
		else
		{
			Route::ErrPg404();
		}
	}

	function ErrPg404()
	{
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header('Location:'.$host.'404');
    }
}
?>