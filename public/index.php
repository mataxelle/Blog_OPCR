<?php

require_once('../vendor/autoload.php');
require '../src/BaseD/connectDB.php';

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader, [
    //'cache' => __DIR__. '/compilation_cache',
]);

$posts = 'SELECT * FROM post';

$postsStatement = $pdo->prepare($posts);
$postsStatement->execute();
$allPosts = $postsStatement->fetchAll();

// On affiche chaque recette une à une
foreach ($allPosts as $post) {
?>
    <p><?php echo $post['title']; ?></p>
    <p><?php echo $post['content']; ?></p>
<?php
}