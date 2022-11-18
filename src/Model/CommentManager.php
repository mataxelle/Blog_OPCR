<?php

namespace App\Model;

use App\BaseD\ConnectDB;
use App\Entity\Comment;
use DateTime;

class CommentManager extends ConnectDB
{
    public function getPostComment(int $postId)
    {
        $db = $this->db;

        $response = $db->prepare('SELECT * FROM comment WHERE post_id = ? AND is_valid = 1 ORDER BY created_at DESC');
        $response->execute(array($postId));

        $result = $response->fetchAll();
        
        return $result;
    }

    public function commentForm(Comment $comment)
    {
        $db = $this->db;

        $addComment = $db->prepare('INSERT INTO comment (post_id, user_id, content, is_valid, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)');

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
}