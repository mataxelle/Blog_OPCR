<?php

namespace App\Controller\AdminController;

use App\Entity\User;
use App\Entity\Post;
use App\Model\CommentManager;
use App\Model\ContactManager;
use App\Model\PostManager;
use App\Model\UserManager;
use App\Twig\TwigRender;

class AdminController extends TwigRender
{
    private $commentManager;
    private $contactManager;
    private $postManager;
    private $userManager;

    public function __construct()
    {
        parent::__construct();
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

        if (isset($_SESSION["is_admin"])) {
            $admin = $_SESSION["is_admin"];
        }

        if (isset($_SESSION["firstname"])) {
            $user = $_SESSION["firstname"];
        }

        $this->twig->display('admin/index.html.twig', [
            'posts' => $posts,
            'users' => $users,
            'messages' => $messages,
            'admin' => $admin,
            'user' => $user
        ]);
    }

    public function posts()
    {
        $posts = $this->postManager->getAllPost();

        if (isset($_SESSION["is_admin"])) {
            $admin = $_SESSION["is_admin"];
        }

        if (isset($_SESSION["firstname"])) {
            $user = $_SESSION["firstname"];
        }

        $this->twig->display('admin/posts.html.twig', [
            'posts' => $posts,
            'admin' => $admin,
            'user' => $user
        ]);
    }

    public function users()
    {
        $users = $this->userManager->getAllUsers();

        if (isset($_SESSION["is_admin"])) {
            $admin = $_SESSION["is_admin"];
        }

        if (isset($_SESSION["firstname"])) {
            $user = $_SESSION["firstname"];
        }

        $this->twig->display('admin/users.html.twig', [
            'users' => $users,
            'admin' => $admin,
            'user' => $user
        ]);
    }

    public function messages()
    {
        $messages = $this->contactManager->getAllMessages();

        if (isset($_SESSION["is_admin"])) {
            $admin = $_SESSION["is_admin"];
        }

        if (isset($_SESSION["firstname"])) {
            $user = $_SESSION["firstname"];
        }

        $this->twig->display('admin/messages.html.twig', [
            'messages' => $messages,
            'admin' => $admin,
            'user' => $user
        ]);
    }

    public function delete(int $id)
    {

        $this->contactManager->deleteMessage($id);

        return header('Location: /admin');
    }
}