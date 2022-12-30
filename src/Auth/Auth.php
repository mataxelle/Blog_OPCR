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

        // End __construct().

    }

    /**
     * Get current user from session storage
     *
     * @return User
     */
    public function getCurrentUser(): User
    {
        return $this->userManager->getUser($this->session->get('id'));

    }

}
