<?php

namespace App\Model;

use App\BaseD\ConnectDB;
use App\Entity\Post;
use DateTime;

class PostManager extends ConnectDB
{
    public function getAllPost()
    {
        $db = $this->db;

        $response = $db->query('SELECT * FROM post WHERE is_published = 1 ORDER BY created_at DESC');

        return $response;
    }

    public function getOnePost(string $slug)
    {
        $db = $this->db;

        $response = $db->prepare('SELECT * FROM post WHERE slug = ?');

        $response->execute([$slug]);

        return $response->fetch();  
    }

    public function postForm(Post $post)
    {
        $db = $this->db;

        $addPost = $db->prepare('INSERT INTO post (user_id, title, slug, image, content, is_published, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');

        $addPost->execute(array(
            $post->getUserId(),
            $post->getTitle(),
            $post->getSlug(),
            $post->getImage(),
            $post->getContent(),
            $post->getIsPublished() ? 1 : 0,
            (new DateTime())->format('Y-m-d h:i:s'),
            (new DateTime())->format('Y-m-d h:i:s')
        ));

        return $addPost;
    }
}