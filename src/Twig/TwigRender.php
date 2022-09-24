<?php

namespace App\Twig;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigRender
{
    /**
     * @var FilesystemLoader
     */
    private $loader;

    protected $twig;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(__DIR__ . './../../templates');
        $this->twig = new Environment($this->loader, []);
    }

}