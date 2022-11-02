<?php

namespace App\Model;

use App\BaseD\ConnectDB;
use DateTime;

class PostManager extends ConnectDB
{
    public function getAllPost()
    {
        $db = $this->db;

        $response = $db->query('SELECT * FROM post ORDER BY created_at DESC');

        return $response;
    }

    public function getOnePost(string $slug)
    {
        $db = $this->db;

        $response = $db->prepare('SELECT * FROM post WHERE slug = ?');

        $response->execute([$slug]);

        return $response->fetch();  
    }

    public function postForm($userId, $title, $slug, $image, $content, $isPublished)
    {
        $db = $this->db;

        $addPost = $db->prepare('INSERT INTO post (user_id, title, slug, image, content, is_published, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');

        $addPost->execute(array(
            $userId,
            $title,
            $slug,
            $image,
            $content,
            $isPublished,
            (new DateTime())->format('Y-m-d h:i:s'),
            (new DateTime())->format('Y-m-d h:i:s')
        ));

        return $addPost;
    }
    
    /*public function postForm()
    {
        $db = $this->db;

        $addPost = $db->prepare('INSERT INTO post (user_id, title, slug, image, content, is_published, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');

        $addPost->execute(array(
            $_POST['user_id'],
            $_POST['title'],
            $_POST['slug'],
            $_POST['image'],
            $_POST['content'],
            $_POST['is_published'],
            (new DateTime())->format('Y-m-d h:i:s'),
            (new DateTime())->format('Y-m-d h:i:s')
        ));

        return $addPost;
    }*/
}