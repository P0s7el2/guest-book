<?php

namespace app\core;

use app\core\View;

class Router {

    //переменная для хранения роутов
    protected $routes = [];
    protected $params = [];
    
    public function __construct() {
        //Подключение роутов
        $arr = require 'app/config/routes.php';
        //цикл для перебора массива с роутами
        foreach ($arr as $key => $val) {
            //вызов метода добавления
            $this->add($key, $val); 
        }
    }

    //добавление маршрута
    public function add($route, $params) {
        //запись роутов в переменную
        $route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?P<\1>\2)', $route);
        $route = '#^'.$route.'$#';
        //запись роутов в свойство
        $this->routes[$route] = $params;
    }

    //проверка маршрута
    public function match() {
        //получение текущего url, удаление /
        $url = trim($_SERVER['REQUEST_URI'], '/');
        //перебираем массив роутов
        foreach ($this->routes as $route => $params) {
            //проверяем совпадение параметров
            if (preg_match($route, $url, $matches)) {
                //цикл по совпадениям
                foreach ($matches as $key => $match) {
                    //проверяем ключ-значение
                    if (is_string($key)) {
                        if (is_numeric($match)) {
                            $match = (int) $match;
                        }
                        //запись в параметры
                        $params[$key] = $match;
                    }
                }
                //запиь в свойство
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    //запуск 
    public function run(){
        //проверка на существование маршрута
        if ($this->match()) {
            //записываем путь в контроллер
            $path = 'app\controllers\\'.ucfirst($this->params['controller']).'Controller';
            //проверка на существование класса
            if (class_exists($path)) {
                //записываем путь в функцию
                $action = $this->params['action'].'Action';
                //проверяем существование
                if (method_exists($path, $action)) {
                    //создаем экз класса 
                    $controller = new $path($this->params);
                    //вызываем экшн
                    $controller->$action();
                } else {
                    View::errorCode(404);
                }
            } else {
                View::errorCode(404);
            }
        } else {
            View::errorCode(404);
        }
    }
}