<?php

namespace App\Twig;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\Form\Forms;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Twig\RuntimeLoader\FactoryRuntimeLoader;
use Symfony\Component\Form\Extension\Csrf\CsrfExtension;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Validator\Validation;

class TwigRender
{

    /**
     * @var FilesystemLoader
     */
    private $loader;

    /**
     * @var Environment
     */
    protected $twig;

    protected $formFactory;


    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $appVarReflection = new \ReflectionClass('\Symfony\Bridge\Twig\AppVariable');
        $vendorTwigBridgeDir = dirname($appVarReflection->getFileName());

        $this->loader = new FilesystemLoader([__DIR__.'./../../templates', $vendorTwigBridgeDir.'/Resources/views/Form']);
        $this->twig = new Environment($this->loader, ['strict_variables' => true]);

        $defaultFormTheme = 'form_div_layout.html.twig';

        $csrfManager = new CsrfTokenManager();

        $formEngine = new TwigRendererEngine([$defaultFormTheme], $this->twig);
        $this->twig->addRuntimeLoader(
            new FactoryRuntimeLoader(
                [
                 FormRenderer::class => function () use ($formEngine, $csrfManager) {
                    return new FormRenderer($formEngine, $csrfManager);
                 },
                ]
            )
        );

        $this->twig->addExtension(new FormExtension());
        $this->twig->addExtension(new TranslationExtension());
        
        $csrfManager = new CsrfTokenManager();

        $validator = Validation::createValidator();
        
        $this->formFactory = Forms::createFormFactoryBuilder()
            ->addExtension(new CsrfExtension($csrfManager))
            ->addExtension(new HttpFoundationExtension())
            ->addExtension(new ValidatorExtension($validator))
            ->getFormFactory();


        // End __construct().
    }

    
}
