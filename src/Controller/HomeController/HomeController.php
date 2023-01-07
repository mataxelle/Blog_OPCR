<?php

namespace App\Controller\HomeController;

use App\Auth\Auth;
use App\Session\Session;
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
     * Session
     *
     * @var Session
     */
    private $session;

    /**
     * Post manager
     *
     * @var PostManager
     */
    private $postManager;


    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->auth = new Auth();
        $this->session = new Session();
        $this->postManager = new PostManager();

        // End__construct().
    }
    
    
    /**
     * Get all validated posts
     *
     * @return array
     */
    public function index()
    {
        $posts = $this->postManager->getAllValidedPost();

        $userName = '';
        $userId = '';
        $isAdmin = '';
        
        if ($this->session->get('firstname')) {
            $userName = $this->session->get('firstname');
        }

        if ($this->session->get('id')) {
            $userId = $this->session->get('id');
        }

        if ($this->session->get('isAdmin')) {
            $isAdmin = $this->session->get('isAdmin');
        }

        $this->twig->display(
            'home/home.html.twig',
            [
             'posts' => $posts,
             'admin' => $isAdmin,
             'user' => $userName,
             'id' => $userId
            ]
        );
        
    }
    
    
}
