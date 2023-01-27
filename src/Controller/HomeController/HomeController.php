<?php

namespace App\Controller\HomeController;

use App\Session\Session;
use App\Twig\TwigRender;
use App\Model\PostManager;

class HomeController extends TwigRender
{

    /**
     * Session
     *
     * @var Session $session Session
     */
    private Session $session;

    /**
     * Post manager
     *
     * @var PostManager $postManager Post manager
     */
    private PostManager $postManager;


    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->session = new Session();
        $this->postManager = new PostManager();

        //End __construct().
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
             'user'  => $userName,
             'id'    => $userId
            ]
        );

    }


}
