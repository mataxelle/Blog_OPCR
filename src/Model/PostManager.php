<?php

namespace App\Model;

use App\BaseD\ConnectDB;

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
}