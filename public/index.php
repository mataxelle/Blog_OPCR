<?php

use App\Exceptions\RouteNotFoundException;
use App\Router\Router;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

$dotenv->required(
    [
    'DB_HOST',
    'DB_DATABASE',
    'DB_USERNAME',
    'DB_PASSWORD',
    ]
);

require_once __DIR__ . './../src/config.php';

$router = new Router();

$router->get('/', ['App\Controller\HomeController\HomeController', 'index']);

try {
    echo $router->resolve($_SERVER['REQUEST_URI']);
} catch (RouteNotFoundException $e) {
    echo $e->getMessage();
}
