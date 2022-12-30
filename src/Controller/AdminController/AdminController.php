<?php

namespace App\Controller\AdminController;

use App\Auth\Auth;
use App\Model\CommentManager;
use App\Model\ContactManager;
use App\Model\PostManager;
use App\Model\UserManager;
use App\Twig\TwigRender;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends TwigRender
{
    
    /**
     * User Auth
     *
     * @var Auth
     */
    private $auth;

    /**
     * Comment manager
     *
     * @var CommentManager
     */
    private $commentManager;

    /**
     * Contact manager
     *
     * @var ContactManager
     */
    private $contactManager;

    /**
     * Post manager
     *
     * @var PostManager
     */
    private $postManager;
    
    /**
     * User manager
     *
     * @var UserManager
     */
    private $userManager;


    public function __construct()
    {
        parent::__construct();
        $this->auth = new Auth();
        $this->commentManager = new CommentManager();
        $this->contactManager = new ContactManager();
        $this->postManager = new PostManager();
        $this->userManager = new UserManager();

        // End __construct()

    }
    

    /**
     * Display all blog infos
     *
     * @return array
     */
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

        $this->twig->display(
            'admin/index.html.twig',
            [
             'posts' => $posts,
             'users' => $users,
             'messages' => $messages,
             'admin' => $isAdmin,
             'user' => $userName,
             'id' => $userId,
             'comments' => $comments
            ]
        );
    }
        
    /**
     * Display all posts
     *
     * @return array
     */
    public function posts()
    {
        $posts = $this->postManager->getAllPost();

        $user = $this->auth->getCurrentUser();
        $userName = $user->getFirstname();
        $isAdmin = $user->getIsAdmin();
        $userId = $user->getId();

        $this->twig->display(
            'admin/posts.html.twig',
            [
             'posts' => $posts,
             'admin' => $isAdmin,
             'user' => $userName,
             'id' => $userId
            ]
        );
    }

    /**
     * Display all comments
     *
     * @return array
     */
    public function comments()
    {
        $comments = $this->commentManager->getAllComments();

        $user = $this->auth->getCurrentUser();
        $userName = $user->getFirstname();
        $isAdmin = $user->getIsAdmin();
        $userId = $user->getId();

        $this->twig->display(
            'admin/comments.html.twig',
            [
             'comments' => $comments,
             'admin' => $isAdmin,
             'user' => $userName,
             'id' => $userId
            ]
        );
    }

    /**
     * Display all users
     *
     * @return array
     */
    public function users()
    {
        $users = $this->userManager->getAllUsers();

        $user = $this->auth->getCurrentUser();
        $userName = $user->getFirstname();
        $isAdmin = $user->getIsAdmin();
        $userId = $user->getId();

        $this->twig->display(
            'admin/users.html.twig',
            [
             'users' => $users,
             'admin' => $isAdmin,
             'user' => $userName,
             'id' => $userId
            ]
        );
    }

    /**
     * Display one user infos
     *
     * @param int $id User $id
     * @return User
     */
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
            $userId = $_SESSION["id"];
        }

        $this->twig->display(
            'user/users_account.html.twig',
            [
             'account' => $account,
             'admin' => $admin,
             'user' => $user,
             'id' => $userId
            ]
        );
    }

    /**
     * Display all messages
     *
     * @return array
     */
    public function messages()
    {
        $messages = $this->contactManager->getAllMessages();

        $user = $this->auth->getCurrentUser();
        $userName = $user->getFirstname();
        $isAdmin = $user->getIsAdmin();
        $userId = $user->getId();

        $this->twig->display(
            'admin/messages.html.twig',
            [
             'messages' => $messages,
             'admin' => $isAdmin,
             'user' => $userName,
             'id' => $userId,
            ]
        );
    }
    
}
