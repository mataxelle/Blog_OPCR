<?php

namespace App\Controller\ContactController;

use App\Twig\TwigRender;
use App\Model\ContactManager;

class ContactController extends TwigRender
{

    
    public function contact()
    {
        $this->twig->display('contact/contact.html.twig');
    }
}