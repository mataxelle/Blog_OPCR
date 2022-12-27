<?php

namespace App\Controller\HomeController;

use App\Auth\Auth;
use App\Twig\TwigRender;
use App\Model\PostManager;

class HomeController extends TwigRender
{
    /**
     * User Auth
     *
     * @var Auth
     */
    private $auth;
    
    /**
     * Post manager
     *
     * @var PostManager
     */
    private $postManager;


    public function __construct()
    {
        parent::__construct();
        $this->auth = new Auth();
        $this->postManager = new PostManager();
    }
    
    
    /**
     * Get all posts
    */
    public function index()
    {
        $posts = $this->postManager->getAllValidedPost();

        $user = $this->auth->getCurrentUser();
        $userName = $user->getFirstname();
        $isAdmin = $user->getIsAdmin();
        $userId = $user->getId();

        $this->twig->display('home/home.html.twig',[
            'posts' => $posts,
            'admin' => $isAdmin,
            'user' => $userName,
            'id' => $userId
        ]);
    }
}