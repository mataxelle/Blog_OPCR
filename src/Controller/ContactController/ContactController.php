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

        $this->twig->display('contact/contact.html.twig');
    }
}