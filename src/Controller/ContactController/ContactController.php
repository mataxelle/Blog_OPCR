<?php

namespace App\Controller\ContactController;

use App\Auth\Auth;
use App\Model\ContactManager;
use App\Twig\TwigRender;

class ContactController extends TwigRender
{
    private $auth;
    private $contactManager;


    public function __construct()
    {
        parent::__construct();
        $this->auth = new Auth();
        $this->contactManager = new ContactManager();
    }
    

    /**
     * Create a contact message
     */
    public function contact()
    {
        if (!empty($_POST)) {
            $data['firstname'] = $_POST['firstname'];
            $data['lastname'] = $_POST['lastname'];
            $data['email'] = $_POST['email'];
            $data['label'] = $_POST['label'];
            $data['message'] = $_POST['message'];

            if ($_POST['label']) {
                $data['label'] = 'information';
            } else {
                $data['label'] = 'question';
            }

            $contact = $this->contactManager->contactForm($data);

            if ($contact) {
                header('Location: /');
            }
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

        $this->twig->display('contact/contact.html.twig', [
            'userInfo' => $user,
            'user' => $userName,
            'admin' => $isAdmin,
            'id' => $userId
        ]);
    }

    /**
     * Get a contact message
     * 
     * @param int $id Contact message id
     */
    public function message(int $id)
    {
        $message = $this->contactManager->getOneMessage($id);

        $user = $this->auth->getCurrentUser();
        $userName = $user->getFirstname();
        $isAdmin = $user->getIsAdmin();
        $userId = $user->getId();

        $this->twig->display('contact/message.html.twig', [
            'message' => $message,
            'user' => $userName,
            'admin' => $isAdmin,
            'id' => $userId
        ]);
    }

    /**
     * Delete a contact message
     * 
     * @param int $id Contact message id
     */
    public function delete(int $id)
    {
        $this->contactManager->deleteMessage($id);

        return header('Location: /admin');
    }
}