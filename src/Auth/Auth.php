<?php

namespace App\Auth;

use App\Entity\User;
use App\Model\UserManager;
use App\Session\Session;

class Auth
{
    private $session;
    private $userManager;
    
    public function __construct()
    {
        $this->session = new Session();
        $this->userManager = new UserManager();
    }
}