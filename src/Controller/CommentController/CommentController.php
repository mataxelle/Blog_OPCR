<?php

namespace App\Controller\CommentController;

use App\Auth\Auth;
use App\Entity\Comment;
use App\Form\CommentFormType;
use App\Twig\TwigRender;
use App\Model\CommentManager;
use App\Model\PostManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CommentController extends TwigRender
{
    private $auth;

    private $commentManager;
    
    private $postManager;
    
    public function __construct()
    {
        parent::__construct();
        $this->auth = new Auth();
        $this->commentManager = new CommentManager();
        $this->postManager = new PostManager();
    }
    
    /**
    * Create a comment
    *
    * @param string $slug Post slug
    */
    public function add(string $slug)
    {
        $user = $this->auth->getCurrentUser();
        $userName = $user->getFirstname();
        $isAdmin = $user->getIsAdmin();
        $userId = $user->getId();
        
        $post = $this->postManager->getOnePost($slug);
        $postSlug = $post->getSlug();
        $postId = $post->getId();

        $comment = new Comment();

        $commentForm = $this->formFactory->createBuilder(CommentFormType::class, $comment, [
            'action' => '/post/' . $postSlug . '/addComment',
            'method' => 'POST',
        ])->getForm();

        $request = Request::createFromGlobals();        
        
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {

            $comment->setPostId($postId);
            $comment->setUserId($userId);
            
            if ($userId !== 1) {
                $comment->setIsValid(0);
            }
            
            $cm = new CommentManager();
            $cm->commentForm($comment);

            $response = new RedirectResponse('/post/' . $postSlug);
            $response->prepare($request);
        
            return $response->send();
        }

        $this->twig->display('comment/comment_add.html.twig', [
            'commentForm' => $commentForm->createView(),
            'user' => $userName,
            'admin' => $isAdmin,
            'id' => $userId
        ]);
    }

    /**
    * Valdate a comment
    *
    * @param int $id Comment id
    */
    public function validation(int $id)
    {
        $comment = $this->commentManager->getComment($id);
        $commentId = $comment->getId();

        $commentForm = $this->formFactory->createBuilder(CommentFormType::class, $comment, [
            'action' => '/admin/comment/' . $commentId . '/validation',
            'method' => 'POST',
        ])->getForm();

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

        $this->twig->display('comment/comment_update.html.twig', [
            'commentForm' => $commentForm->createView(),
            'user' => $userName,
            'admin' => $isAdmin,
            'id' => $userId
        ]);
    }

    /**
    * Delete a comment
    * 
    * @param int $id Comment id
    */
    public function delete(int $id)
    {
        $user = $this->auth->getCurrentUser();
        $isAdmin = $user->getIsAdmin();

        if (!$isAdmin) {
            return header('Location: /');
        }
        
        $this->commentManager->deleteComment($id);

        return header('Location: /admin');
    }
}