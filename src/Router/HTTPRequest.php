<?php

namespace App\Router;

use App\Superglobals\Superglobals;

class HTTPRequest
{
    
    /**
     * Superglobals
     *
     * @var Superglobals
     */
    private $superglobals;


    public function __construct()
    {
        $this->superglobals = new Superglobals();

        // End __construct().
        
    }

    public function requestMethod()
    {
        return $this->superglobals->get_SERVER('REQUEST_METHOD');

        // End requestMethod().

    }
    
    public function getURI()
    {
        if (array_key_exists('path', $this->superglobals->get_GET())) {
            return trim($this->superglobals->get_GET('path'), '/');
        }

        return '';
    }
}
