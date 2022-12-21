<?php

namespace App\Model;

use App\BaseD\ConnectDB;
use App\Entity\Comment;
use DateTime;
use PDO;

class CommentManager extends ConnectDB
{
    public function getAllComments()
    {
        $db = $this->db;

        $response = $db->query('SELECT * FROM comment ORDER BY updatedAt DESC');

        return $response->fetchAll();
    }

    public function getComment(int $id)
    {
        $db = $this->db;

        $response = $db->prepare('SELECT * FROM comment WHERE id = ?');

        $response->bindValue(1, $id, PDO::PARAM_INT);

        $response->execute();

        return new Comment($response->fetch());
    }

    public function getPostComment(int $postId)
    {
        $db = $this->db;

        $response = $db->prepare('SELECT * FROM comment WHERE postId = ? AND isValid = 1 ORDER BY createdAt DESC');

        $response->bindValue(1, $postId, PDO::PARAM_INT);

        $response->execute();

        return $response->fetchAll();
    }

    public function commentForm(Comment $comment)
    {
        $db = $this->db;

        $addComment = $db->prepare('INSERT INTO comment (postId, userId, content, isValid, createdAt, updatedAt) VALUES (?, ?, ?, ?, ?, ?)');

        $addComment->execute(array(
            $comment->getPostId(),
            $comment->getUserId(),
            $comment->getContent(),
            $comment->getIsValid() ? 1 : 0,
            (new DateTime())->format('Y-m-d h:i:s'),
            (new DateTime())->format('Y-m-d h:i:s')
        ));

        return $addComment;
    }

    public function Validation(Comment $comment)
    {
        $db = $this->db;

        $commentValidation = $db->prepare('UPDATE comment SET content = ?, isValid = ? WHERE id = ?');

        $commentValidation->bindValue(1, $comment->getContent(), PDO::PARAM_STR);
        $commentValidation->bindValue(2, $comment->getIsValid() ? 1 : 0, PDO::PARAM_INT);
        $commentValidation->bindValue(3, $comment->getId(), PDO::PARAM_INT);

        $commentValidation->execute();
    }

    public function deleteComment(int $id)
    {
        $db = $this->db;

        $delete = $db->prepare('DELETE FROM comment WHERE id = ?');

        $delete->bindValue(1, $id, PDO::PARAM_INT);

        $delete->execute();
    }
}