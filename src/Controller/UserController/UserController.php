<?php

namespace App\Controller\UserController;

use App\Entity\User;
use App\Twig\TwigRender;
use App\Model\UserManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserController extends TwigRender
{
    private $userManager;

    public function __construct()
    {
        parent::__construct();
        $this->userManager = new UserManager();
    }
    
    public function account()
    {
        $user = '';
        $admin = '';
        
        if (isset($_SESSION["firstname"])) {
            $user = $_SESSION["firstname"];
        }

        if (isset($_SESSION["is_admin"])) {
            $admin = $_SESSION["is_admin"];
        }

        $this->twig->display('user/account.html.twig', [ 
            'user' => $user,
            'admin' => $admin
        ]);
    }

    public function usersAccount(int $id)
    {
        $account = $this->userManager->getUser($id);

        if (isset($_SESSION["is_admin"])) {
            $admin = $_SESSION["is_admin"];
        }

        if (isset($_SESSION["firstname"])) {
            $user = $_SESSION["firstname"];
        }

        $this->twig->display('user/users_account.html.twig', [
            'account' => $account,
            'admin' => $admin,
            'user' => $user
        ]);
    }

    public function delete(int $id)
    {
        $user = '';
        $admin = '';
        
        if (isset($_SESSION["firstname"])) {
            $user = $_SESSION["firstname"];
        }

        if (isset($_SESSION["is_admin"])) {
            $admin = $_SESSION["is_admin"];
        }

        $this->userManager->deleteUser($id);

        if ($admin) {
            return header('Location: /login');
        } else if ($user) {
            return header('Location: /admin');
        }
    }
}