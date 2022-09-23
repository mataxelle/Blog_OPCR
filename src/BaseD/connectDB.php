<?php

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();


$host = $_ENV['DB_HOST'];
$db = $_ENV['DB_DATABASE'];
$user = $_ENV['DB_USERNAME'];
$psw = $_ENV['DB_PASSWORD'];
$port = $_ENV['DB_PORT'];
$charset = $_ENV['DB_CHARSET'];
$dsn = "mysql:host=$host;dbname=$db;port=$port;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $psw, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}