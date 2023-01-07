<?php

namespace App\Superglobals;

class Environnement
{

    /**
     * Envs
     *
     * @var array $envs
     */
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

    /**
     * Get envs
     *
     * @param mixed $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->envs[$key];
    }
}