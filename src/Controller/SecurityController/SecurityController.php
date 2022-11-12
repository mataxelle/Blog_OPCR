<?php

namespace App\Controller\SecurityController;

use App\Entity\User;
use App\Form\UserFormType;
use App\Model\UserManager;
use App\Twig\TwigRender;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SecurityController extends TwigRender
{
    public function __construct()
    {
        parent::__construct();
        $this->userManager = new UserManager();
    }

    public function register()
    {
        $user = new User();

        $form = $this->formFactory->createBuilder(UserFormType::class, $user, [
            'action' => '/register',
            'method' => 'POST',
        ])->getForm();

        $request = Request::createFromGlobals();        
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //$data = $form->getData();
            $user->setIsAdmin(0);
            
            $um = new UserManager();
            $um->registerForm($user);

                    
            $response = new RedirectResponse('/');
            $response->prepare($request);
        
            return $response->send();
        }

        $this->twig->display('security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function login()
    {
        $form = $this->formFactory->createBuilder(UserFormType::class, [
            'action' => '/login',
            'method' => 'POST',
        ])->getForm();

        $request = Request::createFromGlobals();        
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            
            $cm = new UserManager();
            $cm->loginForm(
                $data['email'],
                $data['password']);

                    
            $response = new RedirectResponse('/');
            $response->prepare($request);
        
            return $response->send();
        }

        $this->twig->display('security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}