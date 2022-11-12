<?php

namespace App\Model;

use App\BaseD\ConnectDB;
use App\Entity\Comment;
use DateTime;

class CommentManager extends ConnectDB
{
    public function getPostComment(int $id)
    {
        $db = $this->db;

        $response = $db->query('SELECT * FROM comment WHERE post_id = ? ORDER BY created_at DESC');
        $response->execute(array($id));
        
        return $response;
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