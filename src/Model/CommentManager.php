<?php

namespace App\Model;

use App\BaseD\ConnectDB;
use App\Entity\Comment;
use DateTime;
use PDO;

class CommentManager extends ConnectDB
{
    
    /**
     * Get all comments sorted by update date
     *
     * @return array
     */
    public function getAllComments()
    {
        $database = $this->database;
        
        $response = $database->query('SELECT * FROM comment ORDER BY updatedAt DESC');
        
        return $response->fetchAll();
    }
    
    /**
     * Get a comment by id
     *
     * @param int $commentId Comment id
     * @return Comment
     */
    public function getComment(int $commentId)
    {
        $database = $this->database;
        
        $response = $database->prepare('SELECT * FROM comment WHERE id = ?');
        
        $response->bindValue(1, $commentId, PDO::PARAM_INT);
        
        $response->execute();
        
        return new Comment($response->fetch());
    }
    
    /**
     * Get post comments
     *
     * @param int $postId Post id
     * @return array
     */
    public function getPostComment(int $postId)
    {
        $database = $this->database;
        
        $response = $database->prepare('SELECT * FROM comment WHERE postId = ? AND isValid = 1 ORDER BY createdAt DESC');
        
        $response->bindValue(1, $postId, PDO::PARAM_INT);
        
        $response->execute();
        
        return $response->fetchAll();
    }
    
    /**
     * Insert a new comment
     *
     * @param Comment $comment Comment entity
     * @return int
     */
    public function commentForm(Comment $comment)
    {
        $database = $this->database;
        
        $addComment = $database->prepare('INSERT INTO comment (postId, userId, content, isValid, createdAt, updatedAt) VALUES (?, ?, ?, ?, ?, ?)');
        
        $addComment->execute(
            [
             $comment->getPostId(),
             $comment->getUserId(),
             $comment->getContent(),
             $comment->getIsValid() ? 1 : 0,
             (new DateTime())->format('Y-m-d h:i:s'),
             (new DateTime())->format('Y-m-d h:i:s'),
            ]
        );
        
        return $addComment;
    }
    
    /**
     * Validate a comment
     *
     * @param Comment $comment Comment Entity
     * @return void
     */
    public function Validation(Comment $comment)
    {
        $database = $this->database;
        
        $commentValidation = $database->prepare('UPDATE comment SET content = ?, isValid = ? WHERE id = ?');
        
        $commentValidation->bindValue(1, $comment->getContent(), PDO::PARAM_STR);
        $commentValidation->bindValue(2, $comment->getIsValid() ? 1 : 0, PDO::PARAM_INT);
        $commentValidation->bindValue(3, $comment->getId(), PDO::PARAM_INT);
        
        $commentValidation->execute();
    }
    
    /**
     * Delete a comment
     *
     * @param int $commnetId Comment id
     * @return void
     */
    public function deleteComment(int $commnetId)
    {
        $database = $this->database;
        
        $delete = $database->prepare('DELETE FROM comment WHERE id = ?');
        
        $delete->bindValue(1, $commnetId, PDO::PARAM_INT);
        
        $delete->execute();
    }
}
