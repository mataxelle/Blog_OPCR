<?php

namespace App\Router;

class HTTPRequest
{
    
    public function requestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];

        // End requestMethod()

    }
    
    public function getURI()
    {
        if (array_key_exists('path', $_GET)) {
            return trim($_GET['path'], '/');
        }

        return '';
    }
}
