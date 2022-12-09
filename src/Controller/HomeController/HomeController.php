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
        $posts = $this->postManager->getAllValidedPost();

        $admin = '';
        $user = '';
        $id = '';
        
        if (isset($_SESSION["isAdmin"])) {
            $admin = $_SESSION["isAdmin"];
        }

        if (isset($_SESSION["id"])) {
            $id = $_SESSION["id"];
        }
        
        if (isset($_SESSION["firstname"])) {
            $user = $_SESSION["firstname"];
        }

        $this->twig->display('home/home.html.twig',[ 
            'posts' => $posts,
            'admin' => $admin,
            'user' => $user,
            'id' => $id
        ]);
    }
}