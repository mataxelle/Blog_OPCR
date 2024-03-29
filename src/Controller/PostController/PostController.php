<?php

namespace App\Controller\PostController;

use App\Auth\Auth;
use App\Entity\Post;
use App\Form\PostFormType;
use App\Twig\TwigRender;
use App\Model\CommentManager;
use App\Model\PostManager;
use App\Model\UserManager;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Validator\Constraints\Length;

class PostController extends TwigRender
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
     * User manager
     *
     * @var UserManager
     */
    private $userManager;


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
        $this->userManager = new UserManager();

        // End __construct().
    }


    /**
     * Show a post and his comments
     *
     * @param string $slug Post slug
     * @return void
     */
    public function show(string $slug)
    {
        if ($this->auth->isLoggedIn() === false) {
            $response = new RedirectResponse('/');
            $response->send();
        }

        $post = $this->postManager->getOnePost($slug);

        if (!$post) {
            $response = new RedirectResponse('/notFound');
            $response->send();
        }

        $comments = $this->commentManager->getPostComment($post->getId());
        $authors = [];
        foreach ($comments as $comment) {
            $comAuthorId = $comment['userId'];
            $author = $this->userManager->getUser($comAuthorId);
            $authors[$comAuthorId] = $author;
        }


        $user = $this->auth->getCurrentUser();
        $userName = $user->getFirstname();
        $isAdmin = $user->isAdmin();
        $userId = $user->getId();

        $this->twig->display(
            'post/post_show.html.twig',
            [
                'post'     => $post,
                'comments' => $comments,
                'authors'  => $authors,
                'user'     => $userName,
                'admin'    => $isAdmin,
                'id'       => $userId
            ]
        );
    }


    /**
     * Add a post
     *
     * @return void
     */
    public function add()
    {
        if ($this->auth->isLoggedIn() === false) {
            $response = new RedirectResponse('/');
            $response->send();
        }

        $post = new Post();

        $form = $this->formFactory->createBuilder(
            PostFormType::class,
            $post,
            [
                'action' => '/admin/post/add',
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
                $fileName = uniqid() . '.' . $file->guessExtension();

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

            // End if condition.
        }

        $user = $this->auth->getCurrentUser();
        $userName = $user->getFirstname();
        $isAdmin = $user->isAdmin();
        $userId = $user->getId();

        if ($isAdmin === false) {
            $response = new RedirectResponse('/');
            $response->send();
        }

        $this->twig->display(
            'post/post_add.html.twig',
            [
                'form'  => $form->createView(),
                'user'  => $userName,
                'admin' => $isAdmin,
                'id'    => $userId
            ]
        );
    }


    /**
     * Update a post
     *
     * @param int $postId Post id
     * @return void
     */
    public function update(int $postId)
    {
        if ($this->auth->isLoggedIn() === false) {
            $response = new RedirectResponse('/');
            $response->send();
        }

        $post = $this->postManager->getPostId($postId);

        $oldImage = $post->getImage();

        $pId = $post->getId();

        $form = $this->formFactory->createBuilder(
            PostFormType::class,
            $post,
            [
                'action' => '/admin/post/update/' . $pId,
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
                $fileName = uniqid() . '.' . $file->guessExtension();

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
        $isAdmin = $user->isAdmin();
        $userId = $user->getId();

        if ($isAdmin === false) {
            $response = new RedirectResponse('/');
            $response->send();
        }

        $this->twig->display(
            'post/update.html.twig',
            [
                'form'  => $form->createView(),
                'post'  => $post,
                'user'  => $userName,
                'admin' => $isAdmin,
                'id'  => $userId
            ]
        );
    }

    /**
     * Delete a post
     *
     * @param string $slug Post slug
     * @return void
     */
    public function delete(string $slug)
    {
        $user = $this->auth->getCurrentUser();
        $isAdmin = $user->isAdmin();

        if ($isAdmin === false) {
            $response = new RedirectResponse('/');
            $response->send();
        }

        $this->postManager->deletePost($slug);

        $response = new RedirectResponse('admin');
        $response->send();
    }
}
