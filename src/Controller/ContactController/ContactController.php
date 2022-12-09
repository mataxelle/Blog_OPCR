<?php

namespace App\Controller\ContactController;

use App\Model\ContactManager;
use App\Twig\TwigRender;

class ContactController extends TwigRender
{
    private $contactManager;

    public function __construct()
    {
        parent::__construct();
        $this->contactManager = new ContactManager();
    }

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
        $admin = '';
        
        if (isset($_SESSION["firstname"])) {
            $user = $_SESSION["firstname"];
        }

        if (isset($_SESSION["isAdmin"])) {
            $admin = $_SESSION["isAdmin"];
        }

        if (isset($_SESSION["id"])) {
            $id = $_SESSION["id"];
        }

        $this->twig->display('contact/contact.html.twig', [
            'user' => $user,
            'admin' => $admin,
            'id' => $id
        ]);
    }

    public function message(int $id)
    {
        $message = $this->contactManager->getOneMessage($id);

        if (isset($_SESSION["firstname"])) {
            $user = $_SESSION["firstname"];
        }

        if (isset($_SESSION["isAdmin"])) {
            $admin = $_SESSION["isAdmin"];
        }

        if (isset($_SESSION["id"])) {
            $id = $_SESSION["id"];
        }

        $this->twig->display('contact/message.html.twig', [
            'message' => $message,
            'user' => $user,
            'admin' => $admin,
            'id' => $id
        ]);
    }

    public function delete(int $id)
    {
        $this->contactManager->deleteMessage($id);

        return header('Location: /admin');
    }
}