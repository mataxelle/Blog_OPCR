<?php

namespace App\Controller\ContactController;

use App\Auth\Auth;
use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Model\ContactManager;
use App\Twig\TwigRender;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ContactController extends TwigRender
{
    
    /**
     * User Auth
     *
     * @var Auth
     */
    private $auth;
    
    /**
     * Contact manager
     *
     * @var ContactManager
     */
    private $contactManager;


    public function __construct()
    {
        parent::__construct();
        $this->auth = new Auth();
        $this->contactManager = new ContactManager();

    }
    
    /**
     * Create a contact message
     *
     *@return Response
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
        
        if (isset($_SESSION["firstname"]) && isset($_SESSION["id"]) && isset($_SESSION["isAdmin"])) {
            $user = $this->auth->getCurrentUser();
            $userName = $user->getFirstname();
            $userId = $user->getId();
            $isAdmin = $user->getIsAdmin();
        }

        $this->twig->display(
            'contact/contact_add.html.twig',
            [
             'form' => $form->createView(),
             'userInfo' => $user,
             'user' => $userName,
             'admin' => $isAdmin,
             'id' => $userId
            ]
        );
    }
    
    /**
     * Get a contact message
     *
     * @param int $messageId Contact message id
     */
    public function message(int $messageId)
    {
        $message = $this->contactManager->getOneMessage($messageId);

        $user = $this->auth->getCurrentUser();
        $userName = $user->getFirstname();
        $isAdmin = $user->getIsAdmin();
        $userId = $user->getId();

        $this->twig->display(
            'contact/message.html.twig',
            [
             'message' => $message,
             'user' => $userName,
             'admin' => $isAdmin,
             'id' => $userId
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

        return header('Location: /admin');
    }
}
