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
     * Session
     *
     * @var Session
     */
    private $session;
    
    /**
     * User manager
     *
     * @var UserManager
     */
    private $userManager;


    public function __construct()
    {
        parent::__construct();
        $this->session = new Session();
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
        
        if ($this->session->get('firstname')) {
            $user = $this->session->get('lastname');
        }

        if ($this->session->get('isAdmin')) {
            $admin = $this->session->get('isAdmin');
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
            $email = htmlspecialchars($_POST['email']);
            
            $data['password'] = isset($_POST['password']);
            $data['password'] = htmlspecialchars($_POST['password']);
            $password = $data['password'];
            
            $user = $this->userManager->getUserByEmail($email);

            $isPasswordCorrect = password_verify($password, $user->getPassword());

            if ($isPasswordCorrect === true) {

                $this->session->checkIsStarted();

                // set user in session
                $this->session->set('id', $user->getId());
                $this->session->set('firstname', $user->getFirstname());
                $this->session->set('lastname', $user->getLastname());
                $this->session->set('isAdmin', $user->getIsAdmin());
                $this->session->set('email', $user->getEmail());
                

                if ($user->getIsAdmin() === true) {
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

        $userName = '';
        $userId = '';
        $isAdmin = '';
        
        if ($this->session->get('firstname')) {
            $userName = $this->session->get('firstname');
        }

        if ($this->session->get('id')) {
            $userId = $this->session->get('id');
        }

        if ($this->session->get('isAdmin')) {
            $isAdmin = $this->session->get('isAdmin');
        }

        $this->twig->display(
            'security/login.html.twig',
            [
             'user' => $userName,
             'id' => $userId,
             'admin' => $isAdmin
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
