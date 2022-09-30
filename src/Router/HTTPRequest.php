<?php

namespace App\Router;

class HTTPRequest {
    public function requestMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getURI() {
        return trim($_GET['path'],'/');
    }
}