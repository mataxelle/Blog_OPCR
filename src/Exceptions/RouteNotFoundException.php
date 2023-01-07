<?php

namespace App\Exceptions;

class RouteNotFoundException extends \Exception
{

    /**
     * Message
     * 
     * @var string
     */
    protected $message = 'Cette route n\'existe pas.';

    // Ebd class.
}
