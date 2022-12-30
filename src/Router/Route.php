<?php

namespace App\Router;

class Route
{
    
    private $path;

    private $action;
    
    private $matches;


    public function __construct(string $path, string $action)
    {
        $this->path = trim($path,'/');
        $this->action = $action;

        // End __construct().

    }
    
    public function matches(string $url)
    {
        $reg = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $pathToMatch = "#^$reg$#";

        if (preg_match($pathToMatch, $url, $matches)) {
            $this->matches = $matches;
            return true;
        }
        
    }

    public function execute()
    {
        $params = explode('@', $this->action);
        $controller = new $params[0]();
        $method = $params[1];

        return isset($this->matches[1]) ? $controller->$method($this->matches[1]) : $controller->$method();
    }
}
