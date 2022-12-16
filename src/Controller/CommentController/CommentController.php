<?php

namespace App\Controller\CommentController;

use App\Auth\Auth;
use App\Entity\Comment;
use App\Form\CommentFormType;
use App\Twig\TwigRender;
use App\Model\CommentManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CommentController extends TwigRender
{
    private $auth;
    private $commentManager;

    public function __construct()
    {
        parent::__construct();
        $this->auth = new Auth();
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

    public function add(int $postId)
    {
        $user = $this->auth->getCurrentUser();
        $author = $user->getId();
        $post = $this->postManager->getPostId($postId);

        $comment = new Comment();

        $commentForm = $this->formFactory->createBuilder(CommentFormType::class, $comment, [
            'action' => '/post/' . $postId . '/addComment',
            'method' => 'POST',
        ])->getForm();

        $request = Request::createFromGlobals();        
        
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {

            if (isset($_SESSION["id"])) {
                $id = $_SESSION["id"];
            }

            $comment->setPostId($postId);
            $comment->setUserId($author);
            $comment->setIsValid(0);
            
            /*var_dump($comment);
            die;*/
            
            $cm = new CommentManager();
            $cm->commentForm($comment);

            $response = new RedirectResponse('/');
            $response->prepare($request);
        
            return $response->send();
        }

        $user = '';
        $admin = '';
        $id = '';

        if (isset($_SESSION["firstname"])) {
            $user = $_SESSION["firstname"];
        }

        if (isset($_SESSION["isAdmin"])) {
            $admin = $_SESSION["isAdmin"];
        }

        if (isset($_SESSION["id"])) {
            $id = $_SESSION["id"];
        }

        $this->twig->display('comment/comment_add.html.twig', [
            'commentForm' => $commentForm->createView(),
            'user' => $user,
            'admin' => $admin,
            'id' => $id
        ]);
    }
}