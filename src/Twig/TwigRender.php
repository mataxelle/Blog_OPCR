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
        $appVariableReflection = new \ReflectionClass('\Symfony\Bridge\Twig\AppVariable');
        $vendorTwigBridgeDirectory = dirname($appVariableReflection->getFileName());

        $this->loader = new FilesystemLoader([__DIR__ . './../../templates', $vendorTwigBridgeDirectory.'/Resources/views/Form']);
        $this->twig = new Environment($this->loader, []);
    }

}