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

    public function getOnePost(string $slug)
    {
        $db = $this->db;

        $reponse = $db->prepare('SELECT * FROM post WHERE slug = ?');

        $reponse->execute([$slug]);

        return $reponse->fetch();  
    }
}