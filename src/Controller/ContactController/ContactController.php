<?php

namespace App\Controller\ContactController;

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
        //$contact = $this->contactManager->contactForm();

        $form = $this->formFactory->createBuilder(FormType::class, [
            'action' => '/contact',
            'method' => 'POST',
        ])
            ->add('firstname', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('email', EmailType::class)
            ->add('label',ChoiceType::class, [
                'choices' => [
                    'info' => 'information',
                    'quest' => 'question'
                ]
            ])
            ->add('message', TextareaType::class)
            ->add('button', SubmitType::class, [
                'label' => 'Envoyer',
            ])
            ->getForm();

        $request = Request::createFromGlobals();        
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
        
            //action 
                    
            $response = new RedirectResponse('/');
            $response->prepare($request);
        
            return $response->send();
        }

        $this->twig->display('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}