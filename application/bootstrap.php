<?php 
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'core/route.php';
require_once 'core/database.php';
require_once 'core/user_data.php';


DB::connect(); //Подключение к бд
Route::start(); // запускаем маршрутизатор
?>