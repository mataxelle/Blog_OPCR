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
$router->get('/register', 'App\Controller\SecurityController\SecurityController@register');
$router->post('/register', 'App\Controller\SecurityController\SecurityController@register');
$router->get('/login', 'App\Controller\SecurityController\SecurityController@login');
$router->post('/login', 'App\Controller\SecurityController\SecurityController@login');
$router->get('/post', 'App\Controller\PostController\PostController@index');
$router->get('/post/:slug', 'App\Controller\PostController\PostController@show');
$router->get('/add', 'App\Controller\PostController\PostController@add');
$router->post('/add', 'App\Controller\PostController\PostController@add');
$router->get('/contact', 'App\Controller\ContactController\ContactController@contact');
$router->post('/contact', 'App\Controller\ContactController\ContactController@contact');

$router->run();
