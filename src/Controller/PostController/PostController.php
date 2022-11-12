<?php

namespace App\Controller\PostController;

use App\Entity\Post;
use App\Entity\Comment;
use App\Form\PostFormType;
use App\Form\CommentFormType;
use App\Twig\TwigRender;
use App\Model\PostManager;
use App\Model\CommentManager;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PostController extends TwigRender
{
    private $postManager;

    public function __construct()
    {
        parent::__construct();
        $this->postManager = new PostManager();
        $this->commentManager = new CommentManager();
    }
    
    public function index()
    {
        $posts = $this->postManager->getAllPost();
        $this->twig->display('home/home.html.twig',[ 'posts' => $posts]);
    }

    public function show(string $slug)
    {
        $post = $this->postManager->getOnePost($slug);

        $comment = new Comment();

        $commentForm = $this->formFactory->createBuilder(CommentFormType::class, $comment, [
            'action' => '/addComment',
            'method' => 'POST',
        ])->getForm();

        $request = Request::createFromGlobals();        
        
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {

            $comment->setPostId($post->getId());
            $comment->setUserId(1);
            $comment->setIsValid(0);
            
            
            $cm = new CommentManager();
            $cm->commentForm($comment);

            $response = new RedirectResponse('/');
            $response->prepare($request);
        
            return $response->send();
        }

        $this->twig->display('post/post_show.html.twig',[ 
            'post' => $post,
            'commentForm' => $commentForm->createView()
        ]);
    }

    public function add()
    {
        $post = new Post();

        $form = $this->formFactory->createBuilder(PostFormType::class, $post, [
            'action' => '/add',
            'method' => 'POST',
        ])->getForm();

        $request = Request::createFromGlobals();        
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $post->setUserId(1);

            $pm = new PostManager();
            $pm->postForm($post);

            $response = new RedirectResponse('/');
            $response->prepare($request);
        
            return $response->send();
        }

        $this->twig->display('post/post_add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function update()
    {
    }

    public function delete()
    {
    }
}