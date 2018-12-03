<?php

namespace app\core;


class View {

    //храним строку пути
	public $path;
	//храним массив пути ["controller"]=> "", ["action"]=> ""
	public $route;
	public $layout = 'default';

	public function __construct($route) {
	    // записываем массив пути в свойство класса
	    $this->route = $route;
	    //составляем из массива $route путь controller/action
	    $this->path = $route['controller'] . '/' . $route['action'];
	    //debug($this->route);
	}

	public function render($title, $vars = []) {
	    $path = 'app/views/'.$this->path.'.php';
	    //распоковка переменных
	    extract($vars);
	    // включаем буферизацию вывода
	    ob_start();
	    //проверка на существование файла

        if(file_exists($path)){
            //подключаем шаблон
            require $path;
            //получаем содержимое буфера и удалем
            $content = ob_get_clean();
            //подключаем лэйаут
            require 'app/views/layouts/'.$this->layout.'.php';
        } else {
            echo 'not found view';
        }
	}

    //выбрасывание кастомных страниц ошибок
    public static function errorCode($code){
	    http_response_code($code);
	    $path = 'app/views/errors/'.$code.'.php';
	    if(file_exists($path))
	        require $path;

	    exit;
    }

    //перенаправление
    public static function redirect($url){
        header('location: '.$url);
        exit;
    }

    //функция вывода сообщений
    public function message($status, $message){
        exit(json_encode(['status' => $status, 'message' => $message]));
    }

    //перенаправление для js
    public function location($url){
        exit(json_encode(['url' => $url]));
    }
}	