<?php

namespace App\Controller\ContactController;

use App\Auth\Auth;
use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Model\ContactManager;
use App\Twig\TwigRender;
use App\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ContactController extends TwigRender
{

    /**
     * Session
     *
     * @var Session $session Session
     */
    private Session $session;

    /**
     * User Auth
     *
     * @var Auth $auth Auth
     */
    private Auth $auth;
    
    /**
     * Contact manager
     *
     * @var ContactManager $contactManager Contact manager
     */
    private ContactManager $contactManager;


    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->auth = new Auth();
        $this->session = new Session();
        $this->contactManager = new ContactManager();
        // End __construct().
    }


    /**
     * Create a contact message
     *
     * @return Response
     */
    public function contact(): Response
    {
        $contact = new Contact();

        $form = $this->formFactory->createBuilder(
            ContactFormType::class,
            $contact,
            [
             'action' => '/contact',
             'method' => 'POST',
            ]
        )
            ->getForm();
            
        $request = Request::createFromGlobals();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $contact->setIsAnswered(0);

            $contactmanager = new ContactManager();
            $contactmanager->contactForm($contact);

            $response = new RedirectResponse('/');
            $response->prepare($request);
        
            return $response->send();
        }

        $user = '';
        $userName = '';
        $userId = '';
        $isAdmin = '';
        
        if ($this->session->get('firstname') && $this->session->get('id')) {
            $user = $this->auth->getCurrentUser();
            $userName = $user->getFirstname();
            $userId = $user->getId();
            $isAdmin = $user->isAdmin();
        }

        $this->twig->display(
            'contact/contact_add.html.twig',
            [
             'form'     => $form->createView(),
             'userInfo' => $user,
             'user'     => $userName,
             'admin'    => $isAdmin,
             'id'       => $userId
            ]
        );

    }
    
    /**
     * Get a contact message
     *
     * @param int $messageId Contact message id
     * @return void
     */
    public function message(int $messageId)
    {
        if ($this->auth->isLoggedIn() === false) {
            $response = new RedirectResponse('/');
            $response->send();
        }

        $message = $this->contactManager->getOneMessage($messageId);

        $user = $this->auth->getCurrentUser();
        $userName = $user->getFirstname();
        $isAdmin = $user->isAdmin();
        $userId = $user->getId();

        if (!$isAdmin === false) {
            $response = new RedirectResponse('/');
            $response->send();
        }

        $this->twig->display(
            'contact/message.html.twig',
            [
             'message' => $message,
             'user'    => $userName,
             'admin'   => $isAdmin,
             'id'      => $userId
            ]
        );
    }
    
    /**
     * Delete a contact message
     *
     * @param int $messageId Contact message id
     */
    public function delete(int $messageId)
    {
        $this->contactManager->deleteMessage($messageId);

        $response = new RedirectResponse('/admin');
        $response->send();
    }
    
}
