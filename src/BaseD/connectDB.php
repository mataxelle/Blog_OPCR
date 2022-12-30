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
           'mysql:host='.__DBHOST.';dbname='.__DBDATABASE.';charset=utf8',
           __DBUSERNAME,
           __DBPASSWORD,
           $options
          );

          // end __construct()
          
     }
     
}
