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
}