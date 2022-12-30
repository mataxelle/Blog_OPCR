<?php

namespace App\Controller\UserController;

use App\Auth\Auth;
use App\Twig\TwigRender;
use App\Model\UserManager;

class UserController extends TwigRender
{
    
    /**
     * User Auth
     *
     * @var Auth
     */
    private $auth;
    
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
        $this->userManager = new UserManager();

    }
    
    /**
     * Get a user account information
     *
     * @return User
     */
    public function account()
    {
        $user = $this->auth->getCurrentUser();
        $userName = $user->getFirstname();
        $isAdmin = $user->getIsAdmin();
        $userId = $user->getId();

        $this->twig->display(
            'user/account.html.twig',
            [
             'account' => $user,
             'user' => $userName,
             'admin' => $isAdmin,
             'id' => $userId
            ]
        );
    }
    
    /**
     * Delete a user
     *
     * @param int $userId User id
     */
    public function delete(int $userId)
    {
        $user = $this->auth->getCurrentUser();
        $isAdmin = $user->getIsAdmin();
    
        $this->userManager->deleteUser($userId);

        if ($isAdmin) {
            return header('Location: /admin');
        } else if ($user) {
            return header('Location: /login');
        }
    }
}
