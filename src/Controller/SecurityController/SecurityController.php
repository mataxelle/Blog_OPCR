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
    private $userManager;

    public function __construct()
    {
        parent::__construct();
        $this->userManager = new UserManager();
    }

    /**
     * Create a user
    */
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
            
            $user->setIsAdmin(0);

            $usermanager = new UserManager();
            $usermanager->registerForm($user);

            $response = new RedirectResponse('/login');
            $response->prepare($request);

            return $response->send();
        }

        $user = '';
        $admin = '';
        
        if (isset($_SESSION["firstname"])) {
            $user = $_SESSION["firstname"];
        }

        if (isset($_SESSION["isAdmin"])) {
            $admin = $_SESSION["isAdmin"];
        }

        $this->twig->display('security/register.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'admin' => $admin]
        );
    }

    /**
     * Log a user
    */
    public function login()
    {
        if (!empty($_POST)) {
            $data['email'] = $_POST['email'];
            $data['password'] = $_POST['password'];

            $email = $data['email'];

            $login = $this->userManager->loginForm($email);

            $isPasswordCorrect = password_verify($_POST['password'], $login->getPassword());

            if ($isPasswordCorrect) {

                $session = new Session();
                $session->checkIsStarted();

                $_SESSION['id'] = $login->getId();
                $_SESSION['firstname'] = $login->getFirstname();
                $_SESSION['lastname'] = $login->getLastname();
                $_SESSION['isAdmin'] = $login->getIsAdmin();
                $_SESSION['updatedAt'] = $login->getUpdatedAt();
                $_SESSION['email'] = $login->getEmail();

                header('Location: /');
            } else {
                header('Location: /login');
            }
        }

        $user = '';
        $userId = '';
        $admin = '';
        
        if (isset($_SESSION["firstname"])) {
            $user = $_SESSION["firstname"];
        }

        if (isset($_SESSION["id"])) {
            $userId = $_SESSION["id"];
        }

        if (isset($_SESSION["isAdmin"])) {
            $admin = $_SESSION["isAdmin"];
        }

        $this->twig->display('security/login.html.twig', [
            'user' => $user,
            'id' => $userId,
            'admin' => $admin
        ]);
    }

    /**
     * Logout a user
    */
    public function logout()
    {
        $session = new Session();

        $session->checkIsStarted();
        $session->destroySession();

        return header('Location: /login');
    }
}
