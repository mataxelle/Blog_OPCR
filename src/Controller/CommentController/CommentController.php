<?php

namespace App\Controller\CommentController;

use App\Entity\Comment;
use App\Form\CommentFormType;
use App\Twig\TwigRender;
use App\Model\CommentManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CommentController extends TwigRender
{
    private $commentManager;

    public function __construct()
    {
        parent::__construct();
        $this->commentManager = new CommentManager();
    }

    public function postComment(int $id)
    {
        $comments = $this->commentManager->getPostComment($id);
        //var_dump($comments);
        //die;
        $this->twig->display('comment/comment_show.html.twig',[ 
            'comments' => $comments
        ]);
    }

    public function add()
    {
        $comment = new Comment();

        $commentForm = $this->formFactory->createBuilder(CommentFormType::class, $comment, [
            'action' => '/addComment',
            'method' => 'POST',
        ])->getForm();

        $request = Request::createFromGlobals();        
        
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {

            $comment->setPostId(1);
            $comment->setUserId(1);
            $comment->setIsValid(0);
            //var_dump($comment);
            //die;
            
            $cm = new CommentManager();
            $cm->commentForm($comment);

            $response = new RedirectResponse('/');
            $response->prepare($request);
        
            return $response->send();
        }

        $this->twig->display('comment/comment_add.html.twig', [
            'commentForm' => $commentForm->createView(),
        ]);
    }
}