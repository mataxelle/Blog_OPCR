<?php

namespace App\Controller\PostController;

use App\Twig\TwigRender;
use App\Model\PostManager;

class PostController extends TwigRender
{
    private $postManager;

    public function __construct()
    {
        parent::__construct();
        $this->postManager = new PostManager();
    }

    public function onePost()
    {
        $posts = $this->postManager->getOnePost();
        $this->twig->display('home/home.html.twig',[ 'posts' => $posts]);
    }
}