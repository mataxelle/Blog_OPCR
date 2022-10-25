<?php

namespace App\Entity;

class Comment
{
    private $id;

    private $post_id;

    private $user_id;

    private $content;

    private $is_valid;

    private $created_at;

    private $updated_at;


    public function getId()
    {
        return $this->id;
    }

    public function getPost_id()
    {
        return $this->post_id;
    }

    public function setPost_id($post_id)
    {
        $this->post_id = $post_id;
    }

    public function getUser_id()
    {
        return $this->user_id;
    }

    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getIs_valid()
    {
        return $this->is_valid;
    }

    public function setIs_valid($is_valid)
    {
        $this->is_valid = $is_valid;
    }

    public function getCreated_at()
    {
        return $this->created_at;
    }

    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    public function setUpdated_at($updated_at)
    {
        $this->updated_at = $updated_at;
    }
}