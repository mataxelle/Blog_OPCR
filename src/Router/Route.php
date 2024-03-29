<?php

namespace App\Router;

class Route
{

    /**
     * Path
     *
     * @var string
     */
    private $path;

    /**
     * Action
     *
     * @var string
     */
    private $action;

    private $matches;


    /**
     * Constructor
     *
     * @param string $path   Path
     * @param string $action Action
     * @return void
     */
    public function __construct(string $path, string $action)
    {
        $this->path = trim($path, '/');
        $this->action = $action;
        //End __construct().

    }


    /**
     * Return matches
     *
     * @param string $url Url
     * @return true|void
     */
    public function matches(string $url)
    {
        $reg = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $pathToMatch = "#^$reg$#";

        if (preg_match($pathToMatch, $url, $matches)) {
            $this->matches = $matches;
            return true;
        }
    }

    /**
     * Execute
     *
     * @return mixed
     */
    public function execute()
    {
        $params = explode('@', $this->action);
        $controller = new $params[0]();
        $method = $params[1];

        return isset($this->matches[1]) ? $controller->$method($this->matches[1]) : $controller->$method();
    }
}
