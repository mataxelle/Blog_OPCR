<?php

namespace App\Controller\CommentController;

use App\Auth\Auth;
use App\Entity\Comment;
use App\Form\CommentFormType;
use App\Twig\TwigRender;
use App\Model\CommentManager;
use App\Model\PostManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CommentController extends TwigRender
{

    /**
     * User Auth
     *
     * @var Auth
     */
    private $auth;

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
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->auth = new Auth();
        $this->commentManager = new CommentManager();
        $this->postManager = new PostManager();

        // End __construct().
    }

    
    /**
     * Create a comment
     *
     * @param string $slug Post slug
     * @return Response
     */
    public function add(string $slug): Response
    {
        $user = $this->auth->getCurrentUser();
        $userName = $user->getFirstname();
        $isAdmin = $user->getIsAdmin();
        $userId = $user->getId();
        
        $post = $this->postManager->getOnePost($slug);
        $postSlug = $post->getSlug();
        $postId = $post->getId();

        $comment = new Comment();

        $commentForm = $this->formFactory->createBuilder(
            CommentFormType::class,
            $comment,
            [
             'action' => '/post/'.$postSlug.'/addComment',
             'method' => 'POST',
            ]
        )
            ->getForm();

        $request = Request::createFromGlobals();
        
        $commentForm->handleRequest($request);
        
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setPostId($postId);
            $comment->setUserId($userId);
            
            if ($userId !== 1) {
                $comment->setIsValid(0);
            }
            
            $commentManager = new CommentManager();
            $commentManager->commentForm($comment);

            $response = new RedirectResponse('/post/'.$postSlug);
            $response->prepare($request);
        
            return $response->send();
        }

        $this->twig->display(
            'comment/comment_add.html.twig',
            [
             'commentForm' => $commentForm->createView(),
             'user' => $userName,
             'admin' => $isAdmin,
             'id' => $userId,
             'post' => $post,
            ]
        );
        
    }
    
    /**
     * Validate a comment
     *
     * @param int $commentId Comment id
     */
    public function validation(int $commentId)
    {
        $comment = $this->commentManager->getComment($commentId);
        $comId = $comment->getId();

        $commentForm = $this->formFactory->createBuilder(
            CommentFormType::class,
            $comment,
            [
             'action' => '/admin/comment/'.$comId.'/validation',
             'method' => 'POST',
            ]
        )
        ->getForm();

        $request = Request::createFromGlobals();
        
        $commentForm->handleRequest($request);
        
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            
            $commentmanager = new CommentManager();
            $commentmanager->Validation($comment);

            $response = new RedirectResponse('/admin/comments');
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
            'comment/comment_update.html.twig',
            [
             'commentForm' => $commentForm->createView(),
             'user' => $userName,
             'admin' => $isAdmin,
             'id' => $userId
            ]
        );
    }
    
    /**
     * Delete a comment
     *
     * @param int $commentId Comment id
     */
    public function delete(int $commentId)
    {
        $user = $this->auth->getCurrentUser();
        $isAdmin = $user->getIsAdmin();

        if ($isAdmin === false) {
            $response = new RedirectResponse('/');
            $response->send();
        }
        
        $this->commentManager->deleteComment($commentId);

        $response = new RedirectResponse('/admin');
        $response->send();

    }
    
}
