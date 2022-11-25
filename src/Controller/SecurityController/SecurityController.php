<?php

namespace App\Controller\SecurityController;

use App\Entity\User;
use App\Form\UserFormType;
use App\Model\UserManager;
use App\Session\Session;
use App\Twig\TwigRender;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SecurityController extends TwigRender
{
    public function __construct()
    {
        parent::__construct();
        $this->userManager = new UserManager();
    }

    public function register()
    {
        $user = new User();

        $form = $this->formFactory->createBuilder(UserFormType::class, $user, [
            'action' => '/register',
            'method' => 'POST',
        ])->getForm();

        $request = Request::createFromGlobals();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //$data = $form->getData();
            $user->setIsAdmin(0);

            $um = new UserManager();
            $um->registerForm($user);


            $response = new RedirectResponse('/login');
            $response->prepare($request);

            return $response->send();
        }

        $user = '';
        
        if (isset($_SESSION["firstname"])) {
            $user = $_SESSION["firstname"];
        }

        $this->twig->display('security/register.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    public function login()
    {
        if (!empty($_POST)) {
            $data['email'] = $_POST['email'];
            $data['password'] = $_POST['password'];

            $login = $this->userManager->loginForm($data);

            $isPasswordCorrect = password_verify($_POST['password'], $login['password']);

            if ($isPasswordCorrect) {

                $session = new Session();
                $session->checkIsStarted();

                $_SESSION['id'] = $login['id'];
                $_SESSION['firstname'] = $login['firstname'];
                $_SESSION['lastname'] = $login['lastname'];
                $_SESSION['is_admin'] = $login['is_admin'];
                $_SESSION['updated_at'] = $login['updated_at'];
                $_SESSION['email'] = $_POST['email'];

                header('Location: /');
            } else {
                header('Location: /login');
            }
        }

        $user = '';
        
        if (isset($_SESSION["firstname"])) {
            $user = $_SESSION["firstname"];
        }

        $this->twig->display('security/login.html.twig', [
            'user' => $user
        ]);
    }

    public function logout()
    {
        $session = new Session();

        $session->checkIsStarted();
        $session->destroySession();

        return header('Location: /login');
    }
}
