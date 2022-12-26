<?php

namespace App\Router;

use App\Exceptions\RouteNotFoundException;
use App\Router\HTTPRequest;
use Exception;

class Router
{
    private $url;
    private $routes = [];

    public function __construct(HTTPRequest $request)
    {
        $this->url = $request;
    }
    
    public function get(string $path, string $action)
    {
        $this->routes['GET'][] = new Route($path, $action);
    }

    public function post(string $path, string $action)
    {
        $this->routes['POST'][] = new Route($path, $action);
    }

    public function run()
    {
        foreach ($this->routes[$this->url->requestMethod()] as $route) {
            if($route->matches($this->url->getURI())) {
                return $route->execute();
            }
        }

        //throw new Exception('404 Not Found');
    }
}