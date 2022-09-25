<?php

namespace App\BaseD;

use PDO;
use PDOException;

class ConnectDB extends PDO
{
     protected $db;

     public function __construct()
     {
          $options = [
               PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
               PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
               PDO::ATTR_EMULATE_PREPARES   => false,
          ];

          $this->db = new PDO(
               'mysql:host=' . __DBHOST . ';dbname=' . __DBDATABASE . ';charset=utf8',
               __DBUSERNAME,
               __DBPASSWORD,
               $options
          );
          
     }
     
     /*$dotenv = Dotenv\Dotenv::createImmutable('../');
     $dotenv->load();


     $host = $_ENV['DB_HOST'];
     $db = $_ENV['DB_DATABASE'];
     $user = $_ENV['DB_USERNAME'];
     $psw = $_ENV['DB_PASSWORD'];
     $port = $_ENV['DB_PORT'];
     $charset = $_ENV['DB_CHARSET'];
     $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
     ];

     private function __construct()
     {
          $dsn = "mysql:host=$host;dbname=$db;port=$port;charset=$charset";

          try {
               //$pdo = new PDO($dsn, $user, $psw, $options);
               parent::__construct($dsn, $user, $psw, $options);
           } catch (PDOException $e) {
               die($e->getMessage());
           }
     }*/
}