<?php

namespace App\Controller\PostController;

use App\Auth\Auth;
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
    private $auth;
    private $postManager;

    public function __construct()
    {
        parent::__construct();
        $this->auth = new Auth();
        $this->postManager = new PostManager();
        $this->commentManager = new CommentManager();
    }
    
    public function index()
    {
        $posts = $this->postManager->getAllValidedPost();
        $this->twig->display('home/home.html.twig',[ 'posts' => $posts]);
    }

    public function show(string $slug)
    {
        $post = $this->postManager->getOnePost($slug);

        $comments = $this->commentManager->getPostComment($post->getId());

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

        $this->twig->display('post/post_show.html.twig',[ 
            'post' => $post,
            'comments' => $comments,
            'user' => $user,
            'admin' => $admin,
            'id' => $id
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

            if ($post->getImage() !== null) {
                $file = $form->get('image')->getData();
                $fileName =  uniqid(). '.' .$file->guessExtension();

                try {
                    $file->move('./upload/', $fileName);
                } catch (FileException $e) {
                }

                $post->setImage($fileName);
            };

            $pm = new PostManager();
            $pm->postForm($post);

            $response = new RedirectResponse('/');
            $response->prepare($request);
        
            return $response->send();
        }

        $user = "";
        $admin = "";
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

        $this->twig->display('post/post_add.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'admin' => $admin,
            'id' => $id
        ]);
    }

    public function update(int $id)
    {
        $post = $this->postManager->getPostId($id);
      
        $oldImage = $post->getImage();

        $postId = $post->getId();

        $form = $this->formFactory->createBuilder(PostFormType::class, $post, [
            'action' => '/update/' . $postId,
            'method' => 'POST',
        ])->getForm();

        $request = Request::createFromGlobals();        
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!$post->getUserId()) {
                $post->setUserId(1);
            }

            if ($post->getImage() !== null && $post->getImage() !== $oldImage) {
                $file = $form->get('image')->getData();
                $fileName =  uniqid(). '.' .$file->guessExtension();

                try {
                    $file->move('./upload/', $fileName);
                } catch (FileException $e) {
                }

                $post->setImage($fileName);
            }else {
                $post->setImage($oldImage);
            };


            $pm = new PostManager();
            $pm->postUpdate($post);

            $response = new RedirectResponse('/');
            $response->prepare($request);
        
            return $response->send();
        }

        $user = "";
        $admin = "";
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

        $this->twig->display('post/update.html.twig', [
            'form' => $form->createView(),
            'post' => $post,
            'user' => $user,
            'admin' => $admin,
            'id' => $id
        ]);
    }

    public function delete(string $slug)
    {

        $this->postManager->deletePost($slug);

        return header('Location: /admin');
    }
}