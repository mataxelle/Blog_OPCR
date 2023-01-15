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


    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->superglobals = Superglobals::get();
        // End __construct().
    }

    /**
     * Request
     *
     * @return mixed
     */
    public function requestMethod()
    {
        return $this->superglobals->getServer('REQUEST_METHOD');
        // End requestMethod().
    }
    
    /**
     * Get uri
     *
     * @return string
     */
    public function getURI()
    {
        if (array_key_exists('path', $this->superglobals->getGet())) {
            return trim($this->superglobals->getGet('path'), '/');
        }

        return '';
    }
}
