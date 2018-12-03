<?php

require 'app/lib/Dev.php';

require_once __DIR__ . '/vendor/autoload.php';

use app\core\Router;

session_start();

$router = new Router;

$router->run();