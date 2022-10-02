<?php

namespace App\Model;

use App\BaseD\ConnectDB;

class PostManager extends ConnectDB
{
    public function getAllPost()
    {
        $db = $this->db;

        $reponse = $db->query('SELECT * FROM post ORDER BY created_at DESC');

        return $reponse;
    }

    public function getOnePost(int $id)
    {
        $db = $this->db;

        $reponse = $db->prepare('SELECT * FROM post WHERE id = ?');

        $reponse->execute([$id]);

        return $reponse->fetch();  
    }
}