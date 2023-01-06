<?php

namespace App\Superglobals;

class Environnement
{

    private $envs;


    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->envs = $_ENV;
    }

    public function get($key)
    {
        return $this->envs[$key];
    }
}