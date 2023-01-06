<?php

namespace App\Controller\PostController;

use App\Auth\Auth;
use App\Entity\Post;
use App\Form\PostFormType;
use App\Twig\TwigRender;
use App\Model\CommentManager;
use App\Model\PostManager;
use App\Model\UserManager;
use App\Session\Session;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PostController extends TwigRender
{
    
    /**
     * User Auth
     *
     * @var Auth
     */
    private $auth;

    /**
     * Session
     *
     * @var Session
     */
    private $session;

    /**
     * Comment manager
     *
     * @var CommentManager
     */
    private $commentManager;

    /**
     * Post manager
     *
     * @var PostManager
     */
    private $postManager;

    /**
     * User manager
     *
     * @var UserManager
     */
    private $userManager;
    
    
    public function __construct()
    {
        parent::__construct();
        $this->auth = new Auth();
        $this->session = new Session();
        $this->commentManager = new CommentManager();
        $this->postManager = new PostManager();
        $this->userManager = new UserManager();

        // End __construct().

    }
    
    /**
     * Show a post and his comments
     *
     * @param string $slug Post slug
     */
    public function show(string $slug)
    {
        $post = $this->postManager->getOnePost($slug);

        $comments = $this->commentManager->getPostComment($post->getId());
        /*$authors = [];
        foreach ($comments as $comment) {
            $com = $this->commentManager->getComment($comment['id']);
            $authorId = $com->getUserId();
            $author = $this->userManager->getUser($authorId);
            $authors[$authorId] = $author;
        }
        var_dump($authors);
            die;*/

        $user = $this->auth->getCurrentUser();
        $userName = $user->getFirstname();
        $isAdmin = $user->getIsAdmin();
        $userId = $user->getId();

        $this->twig->display(
            'post/post_show.html.twig',
            [
             'post' => $post,
             'comments' => $comments,
             'user' => $userName,
             'admin' => $isAdmin,
             'id' => $userId
            ]
        );
    }
    
    /**
     * Add a post
     *
     * @return Response
     */
    public function add(): Response
    {
        $post = new Post();

        $form = $this->formFactory->createBuilder(
            PostFormType::class,
            $post,
            [
             'action' => 'admin/post/add',
             'method' => 'POST',
            ]
        )
            ->getForm();

        $request = Request::createFromGlobals();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $post->setUserId(1);

            if ($post->getImage() !== null) {
                $file = $form->get('image')->getData();
                $fileName = uniqid().'.'.$file->guessExtension();

                try {
                    $file->move('./upload/', $fileName);
                } catch (FileException $e) {
                    throw $e;
                }

                $post->setImage($fileName);
            };

            $postmanager = new PostManager();
            $postmanager->postForm($post);

            $response = new RedirectResponse('/');
            $response->prepare($request);
        
            return $response->send();
        }

        $user = $this->auth->getCurrentUser();
        $userName = $user->getFirstname();
        $isAdmin = $user->getIsAdmin();
        $userId = $user->getId();

        if ($isAdmin === false) {
            $response = new RedirectResponse('/');
            $response->send();
        }

        $this->twig->display(
            'post/post_add.html.twig',
            [
             'form' => $form->createView(),
             'user' => $userName,
             'admin' => $isAdmin,
             'id' => $userId
            ]
        );
    }
    
    /**
     * Update a post
     *
     * @param int $postId Post id
     * @return Response
     */
    public function update(int $postId): Response
    {
        $post = $this->postManager->getPostId($postId);
      
        $oldImage = $post->getImage();

        $pId = $post->getId();

        $form = $this->formFactory->createBuilder(
            PostFormType::class,
            $post,
            [
             'action' => '/admin/post/update/'.$pId,
             'method' => 'POST',
            ]
        )
        ->getForm();

        $request = Request::createFromGlobals();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            if (!$post->getUserId()) {
                $post->setUserId(1);
            }

            if ($post->getImage() !== null && $post->getImage() !== $oldImage) {
                $file = $form->get('image')->getData();
                $fileName = uniqid().'.'.$file->guessExtension();

                try {
                    $file->move('./upload/', $fileName);
                } catch (FileException $e) {
                    throw $e;
                }

                $post->setImage($fileName);
            } else {
                $post->setImage($oldImage);
            };


            $postmanager = new PostManager();
            $postmanager->postUpdate($post);

            $response = new RedirectResponse('/');
            $response->prepare($request);
        
            return $response->send();
        }

        $user = $this->auth->getCurrentUser();
        $userName = $user->getFirstname();
        $isAdmin = $user->getIsAdmin();
        $userId = $user->getId();

        if ($isAdmin === false) {
            $response = new RedirectResponse('/');
            $response->send();
        }

        $this->twig->display(
            'post/update.html.twig',
            [
             'form' => $form->createView(),
             'post' => $post,
             'user' => $userName,
             'admin' => $isAdmin,
             'id' => $userId
            ]
        );
    }

    /**
     * Delete a post
     *
     * @param string $slug Post slug
     */
    public function delete(string $slug)
    {
        $user = $this->auth->getCurrentUser();
        $isAdmin = $user->getIsAdmin();

        if ($isAdmin === false) {
            $response = new RedirectResponse('/');
            $response->send();
        }

        $this->postManager->deletePost($slug);

        $response = new RedirectResponse('admin');
        $response->send();
    }
}