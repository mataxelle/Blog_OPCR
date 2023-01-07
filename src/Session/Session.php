<?php

namespace App\Session;

use App\Superglobals\Superglobals;

class Session
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
        $this->superglobals = new Superglobals();

        // End __construct().
    }


    /**
     * Start user session
     *
     * @return true
     */
    public function checkIsStarted()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

    }


    /**
     * Destroy user session
     *
     * @return void
     */
    public function destroySession()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }

    }
    
    /**
     * Retrieve the value for `$key` or return `$default` instead
     *
     * @param string $key The parameter to return
     * @param mixed $default The default value if it contains no value
     * @return mixed
     */
    public function get(string $key, $default= null)
    {
        $this->checkIsStarted();
        if (array_key_exists($key, $this->superglobals->get_SESSION())) {
            return $_SESSION[$key];
        }

        return $default;
    }

    /**
     * Set a value on the item for the provided `$key`
     *
     * @param string $key The parameter to set
     * @param $value The value
     * @return mixed
     */
    public function set(string $key, $value): void
    {
        $this->checkIsStarted();
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key Comment
     * @return void
     */
    public function delete(string $key): void
    {
        $this->checkIsStarted();
        unset($_SESSION[$key]);
    }
}
