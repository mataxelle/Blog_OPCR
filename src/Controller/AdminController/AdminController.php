<?php

namespace App\Controller\AdminController;

use App\Auth\Auth;
use App\Entity\User;
use App\Entity\Post;
use App\Model\CommentManager;
use App\Model\ContactManager;
use App\Model\PostManager;
use App\Model\UserManager;
use App\Twig\TwigRender;

class AdminController extends TwigRender
{
    private $auth;
    private $commentManager;
    private $contactManager;
    private $postManager;
    private $userManager;

    public function __construct()
    {
        parent::__construct();
        $this->auth = new Auth();
        $this->commentManager = new CommentManager();
        $this->contactManager = new ContactManager();
        $this->postManager = new PostManager();
        $this->userManager = new UserManager();
    }

    public function admin()
    {
        $posts = $this->postManager->getAllPost();

        $users = $this->userManager->getAllUsers();

        $messages = $this->contactManager->getAllMessages();

        $comments = $this->commentManager->getAllComments();

        $user = $this->auth->getCurrentUser();
        $userName = $user->getFirstname();
        $isAdmin = $user->getIsAdmin();
        $userId = $user->getId();

        $this->twig->display('admin/index.html.twig', [
            'posts' => $posts,
            'users' => $users,
            'messages' => $messages,
            'admin' => $isAdmin,
            'user' => $userName,
            'id' => $userId,
            'comments' => $comments
        ]);
    }

    public function posts()
    {
        $posts = $this->postManager->getAllPost();

        $user = $this->auth->getCurrentUser();
        $userName = $user->getFirstname();
        $isAdmin = $user->getIsAdmin();
        $userId = $user->getId();

        $this->twig->display('admin/posts.html.twig', [
            'posts' => $posts,
            'admin' => $isAdmin,
            'user' => $userName,
            'id' => $userId
        ]);
    }

    public function comments()
    {
        $comments = $this->commentManager->getAllComments();

        $user = $this->auth->getCurrentUser();
        $userName = $user->getFirstname();
        $isAdmin = $user->getIsAdmin();
        $userId = $user->getId();

        $this->twig->display('admin/comments.html.twig',[ 
            'comments' => $comments,
            'admin' => $isAdmin,
            'user' => $userName,
            'id' => $userId
        ]);
    }

    public function users()
    {
        $users = $this->userManager->getAllUsers();

        $user = $this->auth->getCurrentUser();
        $userName = $user->getFirstname();
        $isAdmin = $user->getIsAdmin();
        $userId = $user->getId();

        $this->twig->display('admin/users.html.twig', [
            'users' => $users,
            'admin' => $isAdmin,
            'user' => $userName,
            'id' => $userId
        ]);
    }

    public function usersAccount(int $id)
    {
        $account = $this->userManager->getUser($id);

        if (isset($_SESSION["isAdmin"])) {
            $admin = $_SESSION["isAdmin"];
        }

        if (isset($_SESSION["firstname"])) {
            $user = $_SESSION["firstname"];
        }

        if (isset($_SESSION["id"])) {
            $id = $_SESSION["id"];
        }

        $this->twig->display('user/users_account.html.twig', [
            'account' => $account,
            'admin' => $admin,
            'user' => $user,
            'id' => $id
        ]);
    }

    public function messages()
    {
        $messages = $this->contactManager->getAllMessages();

        $user = $this->auth->getCurrentUser();
        $userName = $user->getFirstname();
        $isAdmin = $user->getIsAdmin();
        $userId = $user->getId();

        $this->twig->display('admin/messages.html.twig', [
            'messages' => $messages,
            'admin' => $isAdmin,
            'user' => $userName,
            'id' => $userId,
        ]);
    }
}