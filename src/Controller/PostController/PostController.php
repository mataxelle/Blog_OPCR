<?php

namespace App\Controller\PostController;

use App\Twig\TwigRender;
use App\Model\PostManager;

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
        if (!empty($_POST))
        {
           
            $data['user_id'] = $_POST['user_id'];
            $data['title'] = $_POST['title'];
            $data['slug'] = $_POST['slug'];
            $data['image'] = $_POST['image'];
            $data['content'] = $_POST['content'];

            if(!empty($_POST['is_published'])) {
                $data['is_published'] = 1;
            }
            else {
                $data['is_published'] = 0;
            }

            $post = $this->postManager->postForm($data);

            if($post)
            {
                header('Location: /');
            }
        }

        $this->twig->display('post/add.html.twig');
    }

    public function update()
    {
    }

    public function delete()
    {
    }
}