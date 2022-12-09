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
    
    public function account(int $id)
    {
        $account = $this->userManager->getUser($id);
        
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

        $this->twig->display('user/account.html.twig', [ 
            'account' => $account,
            'user' => $user,
            'admin' => $admin,
            'id' => $id
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