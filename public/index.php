<?php

use App\Exceptions\RouteNotFoundException;
use App\Router\Router;

require_once __DIR__ . '/../vendor/autoload.php';
require '../src/BaseD/ConnectDB.php';

$router = new Router();

$router->get('/', ['App\Controller\HomeController\HomeController', 'index']);

try {
    echo $router->resolve($_SERVER['REQUEST_URI']);
} catch (RouteNotFoundException $e) {
    echo $e->getMessage();
}
