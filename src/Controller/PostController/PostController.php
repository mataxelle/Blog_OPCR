<?php

namespace App\Controller\PostController;

use App\Entity\Post;
use App\Form\PostFormType;
use App\Twig\TwigRender;
use App\Model\PostManager;
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
    }
    
    public function index()
    {
        $posts = $this->postManager->getAllPost();
        $this->twig->display('home/home.html.twig',[ 'posts' => $posts]);
    }

    public function show(string $slug)
    {
        $post = $this->postManager->getOnePost($slug);
        $this->twig->display('post/post_show.html.twig',[ 'post' => $post]);
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

            $data = $form->getData();
            
            $pm = new PostManager();
            $pm->postForm(
                $data->userId = 1,
                $data->title,
                $data->slug,
                $data->image,
                $data->content,
                $data->isPublished);
                
                //Condition à faire
                if ($data->isPublished) {
                    $data->isPublished = 1;
                } else {
                    $data->isPublished = 0;
                }

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