<?php

require_once('./vendor/autoload.php');

$loader = new \Twig\Loader\FilesystemLoader(__DIR__. '/templates');
$twig = new \Twig\Environment($loader, [
    //'cache' => __DIR__. '/compilation_cache',
]);

echo $twig->render('base.html.twig', ['name' => 'Lucie']);