<?php

namespace App\BaseD;

use PDO;

class ConnectDB extends PDO
{
    
    protected $database;
     
    
    public function __construct()
    {
          $options = [
                      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                      PDO::ATTR_EMULATE_PREPARES   => false,
                     ];
                    
          $this->database = new PDO(
           'mysql:host='.filter_input(INPUT_ENV, "DBHOST").';dbname='.filter_var($_ENV['DBDATABASE']).';charset=utf8',
           filter_var($_ENV['DBUSERNAME']),
           filter_var($_ENV['DBPASSWORD']),
           $options
          );

          // End __construct(). filter_input(INPUT_ENV, "DBUSERNAME")  filter_input(INPUT_ENV, "DBPASSWORD")
          
     }
     
}
