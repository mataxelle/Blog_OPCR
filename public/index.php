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

session_start();
/*var_dump($_SESSION);
die;*/

$router->get('/', 'App\Controller\HomeController\HomeController@index');
$router->get('/register', 'App\Controller\SecurityController\SecurityController@register');
$router->post('/register', 'App\Controller\SecurityController\SecurityController@register');
$router->get('/login', 'App\Controller\SecurityController\SecurityController@login');
$router->post('/login', 'App\Controller\SecurityController\SecurityController@login');
$router->get('/logout', 'App\Controller\SecurityController\SecurityController@logout');
$router->get('/post', 'App\Controller\PostController\PostController@index');
$router->get('/post/:slug', 'App\Controller\PostController\PostController@show');
$router->get('/add', 'App\Controller\PostController\PostController@add');
$router->post('/add', 'App\Controller\PostController\PostController@add');
$router->get('/delete/:slug', 'App\Controller\PostController\PostController@delete');
$router->get('/comment', 'App\Controller\CommentController\CommentController@postComment');
$router->post('/addComment', 'App\Controller\PostController\PostController@show');
$router->get('/account', 'App\Controller\UserController\UserController@account');
$router->get('/account/:id', 'App\Controller\UserController\UserController@usersAccount');
$router->get('/delete/:id', 'App\Controller\UserController\UserController@delete');
$router->get('/contact', 'App\Controller\ContactController\ContactController@contact');
$router->post('/contact', 'App\Controller\ContactController\ContactController@contact');
$router->get('/message/:id', 'App\Controller\ContactController\ContactController@message');
$router->get('/admin', 'App\Controller\AdminController\AdminController@admin');
$router->get('/admin/posts', 'App\Controller\AdminController\AdminController@posts');
$router->get('/admin/users', 'App\Controller\AdminController\AdminController@users');
$router->get('/admin/messages', 'App\Controller\AdminController\AdminController@messages');
$router->get('/delete/:id', 'App\Controller\ContactController\ContactController@delete');

$router->run();
