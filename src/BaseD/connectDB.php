<?php

namespace App\BaseD;

use PDO;
use App\Superglobals\Environnement;

class ConnectDB extends PDO
{

    /**
     * PDO
     *
     * @var \PDO
     */
    protected $database;


    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $options = [
                      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                      PDO::ATTR_EMULATE_PREPARES   => false,
                   ];
        
        $env = new Environnement();

        $this->database = new PDO(
          'mysql:host='.$env->get("DBHOST").';dbname='.$env->get('DBDATABASE').';charset=utf8',
          $env->get('DBUSERNAME'),
          $env->get('DBPASSWORD'),
          $options
        );
        // End __construct().
    }

   
}
