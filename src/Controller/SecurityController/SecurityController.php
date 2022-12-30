<?php

namespace App\Controller\SecurityController;

use App\Entity\User;
use App\Form\UserFormType;
use App\Model\UserManager;
use App\Session\Session;
use App\Twig\TwigRender;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SecurityController extends TwigRender
{
    
    /**
     * User manager
     *
     * @var UserManager
     */
    private $userManager;


    public function __construct()
    {
        parent::__construct();
        $this->userManager = new UserManager();

        // End __construct().
        
    }

    /**
     * Create a user
     * 
     * @return Response
     */
    public function register(): Response
    {
        $user = new User();

        $form = $this->formFactory->createBuilder(
            UserFormType::class,
            $user,
            [
             'action' => '/register',
             'method' => 'POST',
            ]
        )
            ->getForm();

        $request = Request::createFromGlobals();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() === true && $form->isValid() === true) {
            
            $user->setIsAdmin(0);
            $usermanager = new UserManager();
            $usermanager->registerForm($user);
            $response = new RedirectResponse('/login');
            $response->prepare($request);

            return $response->send();
        }

        $user = '';
        $admin = '';
        
        if (isset($_SESSION["firstname"]) === true) {
            $user = $_SESSION["firstname"];
        }

        if (isset($_SESSION["isAdmin"]) === true) {
            $admin = $_SESSION["isAdmin"];
        }

        $this->twig->display(
            'security/register.html.twig',
            [
             'form' => $form->createView(),
             'user' => $user,
             'admin' => $admin
            ]
        );
    }
    
    /**
     * Log a user
     *
     */
    public function login()
    {
        if (empty($_POST) === false) {
            $data['email'] = $_POST['email'];
            $data['password'] = $_POST['password'];

            $email = $data['email'];

            $login = $this->userManager->loginForm($email);

            $isPasswordCorrect = password_verify($_POST['password'], $login->getPassword());

            if ($isPasswordCorrect === true) {

                $session = new Session();
                $session->checkIsStarted();

                $_SESSION['id'] = $login->getId();
                $_SESSION['firstname'] = $login->getFirstname();
                $_SESSION['lastname'] = $login->getLastname();
                $_SESSION['isAdmin'] = $login->getIsAdmin();
                $_SESSION['updatedAt'] = $login->getUpdatedAt();
                $_SESSION['email'] = $login->getEmail();

                if ($login->getIsAdmin() === true) {
                    $response = new RedirectResponse('/admin');
                    $response->send();
                } else {
                    $response = new RedirectResponse('/');
                    $response->send();
                }
            } else {

                $response = new RedirectResponse('/login');
                $response->send();
                
            }
        }

        $user = '';
        $userId = '';
        $admin = '';
        
        if (isset($_SESSION["firstname"]) === true) {
            $user = $_SESSION["firstname"];
        }

        if (isset($_SESSION["id"]) === true) {
            $userId = $_SESSION["id"];
        }

        if (isset($_SESSION["isAdmin"]) === true) {
            $admin = $_SESSION["isAdmin"];
        }

        $this->twig->display(
            'security/login.html.twig',
            [
             'user' => $user,
             'id' => $userId,
             'admin' => $admin
            ]
        );
    }
    
    /**
     * Logout a user
     *
     * @return void
     */
    public function logout()
    {
        $session = new Session();

        $session->checkIsStarted();
        $session->destroySession();

        $response = new RedirectResponse('/login');
        $response->send();
    }
}
