<?php

namespace App\Router;

use App\Exceptions\RouteNotFoundException;
use App\Router\HTTPRequest;
use Exception;

class Router
{

    /**
     * Url
     *
     * @var url
     */
    private $url;

    /**
     * Routes
     *
     * @var array $routes
     */
    private $routes = [];


    /**
     * Constructor
     *
     * @param HTTPRequest $request Request
     * @return void
     */
    public function __construct(HTTPRequest $request)
    {
        $this->url = $request;

    }


    /**
     * Get
     *
     * @param string $path   Path
     * @param string $action Action
     * @return void
     */
    public function get(string $path, string $action)
    {
        $this->routes['GET'][] = new Route($path, $action);

    }

    
    /**
     * Post
     *
     * @param string $path   Path
     * @param string $action Action
     * @return void
     */
    public function post(string $path, string $action)
    {
        $this->routes['POST'][] = new Route($path, $action);
    }


    /**
     * Run
     *
     * @return mixed
     */
    public function run()
    {
        foreach ($this->routes[$this->url->requestMethod()] as $route) {
            if ($route->matches($this->url->getURI())) {
                return $route->execute();
            }
        }

        // Throw new Exception('404 Not Found').
    }
}
