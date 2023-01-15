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
     * @params $envs The envs
     * @return void
     */
    public function __construct($envs)
    {
        $this->envs = $envs;
        // End __construct().
    }


    /**
     * Get envs
     *
     * @param mixed $key Comment
     * @return mixed
     */
    public function get($key)
    {
        return $this->envs[$key];
    }
}
