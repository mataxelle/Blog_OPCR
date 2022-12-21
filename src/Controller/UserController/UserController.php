<?php

namespace App\Controller\UserController;

use App\Auth\Auth;
use App\Entity\User;
use App\Twig\TwigRender;
use App\Model\UserManager;

class UserController extends TwigRender
{
    private $auth;
    private $userManager;

    public function __construct()
    {
        parent::__construct();
        $this->auth = new Auth();
        $this->userManager = new UserManager();
    }
    
    public function account(int $id)
    {
        $user = $this->auth->getCurrentUser();
        $userName = $user->getFirstname();
        $isAdmin = $user->getIsAdmin();
        $userId = $user->getId();

        $this->twig->display('user/account.html.twig', [ 
            'account' => $user,
            'user' => $userName,
            'admin' => $isAdmin,
            'id' => $userId
        ]);
    }

    public function delete(int $id)
    {
        $user = '';
        $admin = '';
        $id = '';
        
        if (isset($_SESSION["firstname"])) {
            $user = $_SESSION["firstname"];
        }

        if (isset($_SESSION["isAdmin"])) {
            $admin = $_SESSION["isAdmin"];
        }

        if (isset($_SESSION["id"])) {
            $id = $_SESSION["id"];
        }

        $this->userManager->deleteUser($id);

        if ($admin) {
            return header('Location: /admin');
        } else if ($user) {
            return header('Location: /login');
        }
    }
}