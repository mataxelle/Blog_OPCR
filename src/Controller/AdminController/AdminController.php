<?php

namespace App\Controller\AdminController;

use App\Entity\User;
use App\Entity\Post;
use App\Model\CommentManager;
use App\Model\PostManager;
use App\Model\UserManager;
use App\Twig\TwigRender;

class AdminController extends TwigRender
{
    private $commentManager;
    private $postManager;
    private $userManager;

    public function __construct()
    {
        parent::__construct();
        $this->commentManager = new CommentManager();
        $this->postManager = new PostManager();
        $this->userManager = new UserManager();
    }

    public function admin()
    {

        $posts = $this->postManager->getAllPost();

        $users = $this->userManager->getAllUsers();

        if (isset($_SESSION["is_admin"])) {
            $admin = $_SESSION["is_admin"];
        }

        if (isset($_SESSION["firstname"])) {
            $user = $_SESSION["firstname"];
        }

        $this->twig->display('admin/index.html.twig', [
            'posts' => $posts,
            'users' => $users,
            'admin' => $admin,
            'user' => $user
        ]);
    }
}