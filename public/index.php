<?php

use App\Exceptions\RouteNotFoundException;
use App\Router\HTTPRequest;
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

$request = new HTTPRequest;

$router = new Router($request);

$router->get('/', 'App\Controller\HomeController\HomeController@index');
$router->get('/post', 'App\Controller\PostController\PostController@index');
$router->get('/post/:id', 'App\Controller\PostController\PostController@show');

$router->run();
