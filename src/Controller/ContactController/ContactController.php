<?php

namespace App\Controller\ContactController;

use App\Twig\TwigRender;
use App\Model\ContactManager;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Csrf\CsrfExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator;
use Symfony\Component\Security\Csrf\TokenStorage\SessionTokenStorage;
use Symfony\Component\Validator\Validation;
use Twig\RuntimeLoader\FactoryRuntimeLoader;

class ContactController extends TwigRender
{

    
    public function contact()
    {
        $defaultFormTheme = 'form_div_layout.html.twig';

        /*$requestStack = new RequestStack();
        $requestStack->push($request);

        $csrfGenerator = new UriSafeTokenGenerator();
        $csrfStorage = new SessionTokenStorage($requestStack);
        $csrfManager = new CsrfTokenManager($csrfGenerator, $csrfStorage);*/
        $csrfManager = new CsrfTokenManager();

        $formEngine = new TwigRendererEngine([$defaultFormTheme], $this->twig);
        $this->twig->addRuntimeLoader(new FactoryRuntimeLoader([
            FormRenderer::class => function () use ($formEngine, $csrfManager) {
                return new FormRenderer($formEngine, $csrfManager);
            },
        ]));

        $this->twig->addExtension(new FormExtension());
        $this->twig->addExtension(new TranslationExtension());
        
        $validator = Validation::createValidator();

        $formFactory = Forms::createFormFactoryBuilder()
            ->addExtension(new CsrfExtension($csrfManager))
            ->addExtension(new ValidatorExtension($validator))
            ->getFormFactory();

        $form = $formFactory->createBuilder()
            ->add('firstname', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('email', EmailType::class)
            ->add('label',ChoiceType::class, [
                'choices' => [
                    'info' => 'information',
                    'quest' => 'question'
                ]
            ])
            ->add('message', TextareaType::class)
            ->add('button', ButtonType::class, [
                'label' => 'Envoyer',
            ])
            ->getForm();

        $this->twig->display('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}