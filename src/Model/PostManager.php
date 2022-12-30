<?php

namespace App\Model;

use App\BaseD\ConnectDB;
use App\Entity\Post;
use DateTime;
use PDO;

class PostManager extends ConnectDB
{
    
    /**
     * Get all posts sorted by creation date
     *
     * @return array
     */
    public function getAllPost()
    {
        $database = $this->database;
        
        $response = $database->query('SELECT * FROM post ORDER BY createdAt DESC');
        
        return $response->fetchAll();
    }
    
    /**
     * Get all validated posts
     *
     * @return array
     */
    public function getAllValidedPost()
    {
        $database = $this->database;
        
        $response = $database->query('SELECT * FROM post WHERE isPublished = 1 ORDER BY createdAt DESC');
        
        return $response->fetchAll();
    }
    
    /**
     * Get a post by id
     *
     * @param  int $postId Post id
     * @return Post
     */
    public function getPostId(int $postId)
    {
        $database = $this->database;
        
        $response = $database->prepare('SELECT * FROM post WHERE id = ?');
        
        $response->bindValue(1, $postId, PDO::PARAM_INT);
        
        $response->execute();
        
        return new Post($response->fetch());
    }
    
    /**
     * get a post by slug
     *
     * @param string $slug Post slug
     * @return Post
     */
    public function getOnePost(string $slug)
    {
        $database = $this->database;
        
        $response = $database->prepare('SELECT * FROM post WHERE slug = ?');
        
        $response->bindValue(1, $slug, PDO::PARAM_STR);
        
        $response->execute();
        
        return new Post($response->fetch());
    }
    
    /**
     * Insert a new post
     *
     * @param Post $post Post Entity
     * @return int
     */
    public function postForm(Post $post)
    {
        $database = $this->database;
        
        $addPost = $database->prepare('INSERT INTO post (userId, title, slug, image, content, isPublished, createdAt, updatedAt) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        
        $addPost->execute(
            [
             $post->getUserId(),
             $post->getTitle(),
             $post->getSlug(),
             $post->getImage(),
             $post->getContent(),
             $post->getIsPublished() ? 1 : 0,
             (new DateTime())->format('Y-m-d h:i:s'),
             (new DateTime())->format('Y-m-d h:i:s'),
            ]
        );
        
        return $addPost;
    }

    /**
     * Update a post
     * 
     * @param Post $post Post Entity
     * @return void
     */
    public function postUpdate(Post $post)
    {
        $database = $this->database;

        $upPost = $database->prepare('UPDATE post SET userId = ?, title = ?, slug = ?, image = ?, content = ?, isPublished = ?, updatedAt = ? WHERE id = ?');

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

    /**
     * Delete a post
     *
     * @param  string $slug Post slug
     * @return void
     */
    public function deletePost(string $slug)
    {
        $database = $this->database;

        $delete = $database->prepare('DELETE FROM post WHERE slug = ?');
        
        $delete->execute([$slug]);
    }
}
