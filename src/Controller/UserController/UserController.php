<?php

namespace App\Controller\UserController;

use App\Auth\Auth;
use App\Form\UpdateAccountFormType;
use App\Twig\TwigRender;
use App\Model\UserManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

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


    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->auth = new Auth();
        $this->userManager = new UserManager();

        // End __construct().
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
        $isAdmin = $user->isAdmin();
        $userId = $user->getId();

        $this->twig->display(
            'user/account.html.twig',
            [
             'account' => $user,
             'user'    => $userName,
             'admin'   => $isAdmin,
             'id'      => $userId
            ]
        );

    }

    /**
     * Update account
     *
     * @param int $userId User id
     * @return Response
     */
    public function updateAccount(int $userId): Response
    {
        $user = $this->auth->getCurrentUser();
        $userName = $user->getFirstname();
        $isAdmin = $user->isAdmin();
        $userId = $user->getId();

        $form = $this->formFactory->createBuilder(
            UpdateAccountFormType::class,
            $user,
            [
             'action' => '/account/update/'.$userId,
             'method' => 'POST',
            ]
        )
            ->getForm();

        $request = Request::createFromGlobals();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userManager->updateForm($user);
            $response = new RedirectResponse('/account/'.$userId);
            $response->prepare($request);

            return $response->send();
        }

        $this->twig->display(
            'user/update.html.twig',
            [
             'form'    => $form->createView(),
             'account' => $user,
             'user'    => $userName,
             'admin'   => $isAdmin,
             'id'      => $userId
            ]
        );

    }


    /**
     * Delete a user
     *
     * @param int $userId User id
     * @return void
     */
    public function delete(int $userId)
    {
        $user = $this->auth->getCurrentUser();
        $isAdmin = $user->isAdmin();

        $this->userManager->deleteUser($userId);
        
        if ($isAdmin) {
            $response = new RedirectResponse('/admin');
            $response->send();
        } else if ($user) {
            $response = new RedirectResponse('/login');
            $response->send();
        }


    }


}
