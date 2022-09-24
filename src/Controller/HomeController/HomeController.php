<?php

namespace App\Controller\HomeController;

use App\Twig\TwigRender;

class HomeController extends TwigRender
{
    public function index()
    {
        $this->twig->display('home/home.html.twig');
    }
}