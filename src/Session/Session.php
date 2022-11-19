<?php

namespace App\Session;

class Session
{
    public function checkIsStarted()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function destroySession()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
    
    public function get(string $key, $default = null)
    {
        $this->checkIsStarted();
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }
        return $default;
    }

    public function set(string $key, $value): void
    {
        $this->checkIsStarted();
        $_SESSION[$key] = $value;
    }

    public function delete(string $key): void
    {
        $this->checkIsStarted();
        unset($_SESSION[$key]);
    }
}