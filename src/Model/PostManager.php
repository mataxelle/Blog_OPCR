<?php

namespace App\Model;

use App\BaseD\ConnectDB;
use App\Entity\Post;
use DateTime;
use PDO;

class PostManager extends ConnectDB
{
    public function getAllPost()
    {
        $db = $this->db;

        $response = $db->query('SELECT * FROM post ORDER BY createdAt DESC');

        return $response->fetchAll();
    }

    public function getAllValidedPost()
    {
        $db = $this->db;

        $response = $db->query('SELECT * FROM post WHERE isPublished = 1 ORDER BY createdAt DESC');

        return $response->fetchAll();
    }

    public function getPostId(int $id)
    {
        $db = $this->db;

        $response = $db->prepare('SELECT * FROM post WHERE id = ?');

        $response->bindValue(1, $id, PDO::PARAM_INT);

        $response->execute();

        return new Post($response->fetch());  
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

        $addPost = $db->prepare('INSERT INTO post (userId, title, slug, image, content, isPublished, createdAt, updatedAt) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');

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

    public function postUpdate(Post $post)
    {
        $db = $this->db;

        $upPost = $db->prepare('UPDATE post SET userId = ?, title = ?, slug = ?, image = ?, content = ?, isPublished = ?, updatedt = ? WHERE id = ?');

        $upPost->bindValue(1, $post->getUserId(), PDO::PARAM_INT);
        $upPost->bindValue(2, $post->getTitle(), PDO::PARAM_STR);
        $upPost->bindValue(3, $post->getSlug(), PDO::PARAM_STR);
        $upPost->bindValue(4, $post->getImage(), PDO::PARAM_STR);
        $upPost->bindValue(5, $post->getContent(), PDO::PARAM_STR);
        $upPost->bindValue(6, $post->getIsPublished() ? 1 : 0, PDO::PARAM_INT);
        $upPost->bindValue(7, (new DateTime())->format('Y-m-d h:i:s'));
        $upPost->bindValue(8, $post->getId(), PDO::PARAM_INT);

        $upPost->execute();
    }

    public function deletePost(string $slug)
    {
        $db = $this->db;

        $delete = $db->prepare('DELETE FROM post WHERE slug = ?');
        
        $delete->execute([$slug]);
    }
}