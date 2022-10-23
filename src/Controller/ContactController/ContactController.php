<?php

namespace App\Controller\ContactController;

use App\Form\ContactFormType;
use App\FormFactory\FormFactory;
use App\Model\ContactManager;
use App\Twig\TwigRender;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ContactController extends TwigRender
{   
    private $contactManager;

    public function __construct()
    {
        parent::__construct();
        $this->contactManager = new FormFactory();
    }

    public function contact()
    {
        $form = $this->formFactory->createBuilder(ContactFormType::class, [
            'action' => '/contact',
            'method' => 'POST',
        ])->getForm();

        $request = Request::createFromGlobals();        
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            
            $cm = new ContactManager();
            $cm->contactForm(
                $data['firstname'],
                $data['lastname'],
                $data['email'],
                $data['label'],
                $data['message']);
                    
            $response = new RedirectResponse('/');
            $response->prepare($request);
        
            return $response->send();
        }

        $this->twig->display('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}