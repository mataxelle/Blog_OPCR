<?php

namespace App\Controller\SecurityController;

use App\Form\UserFormType;
use App\Model\UserManager;
use App\FormFactory\FormFactory;
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
        $form = $this->formFactory->createBuilder(UserFormType::class, [
            'action' => '/register',
            'method' => 'POST',
        ])->getForm();

        $request = Request::createFromGlobals();        
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            
            $cm = new UserManager();
            $cm->registerForm(
                $data['firstname'],
                $data['lastname'],
                $data['is_admin'] = 0,
                $data['email'],
                $data['password'],
                $data['created_at'],
                $data['updated_at']);

                    
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