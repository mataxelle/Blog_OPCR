<?php

namespace App\Controller\HomeController;

use App\Twig\TwigRender;
use App\Model\PostManager;

class HomeController extends TwigRender
{
    private $postManager;

    public function __construct()
    {
        parent::__construct();
        $this->postManager = new PostManager();
    }

    public function index()
    {
        $posts = $this->postManager->getAllPost();
        $this->twig->display('home/home.html.twig',[ 'posts' => $posts]);
    }
}