<?php

namespace App\Model;

use App\BaseD\ConnectDB;

class ContactManager extends ConnectDB
{
    public function getAllPost()
    {
        $db = $this->db;

        $response = $db->query('SELECT * FROM post ORDER BY created_at DESC');

        return $response;
    }
    
    function contactForm()
    {
        $db = $this->db;

        $addContact = $db->prepare('INSERT INTO contact (firstname, lastname, email, label, message ) VALUES (?, ?, ?, ?, ?)');

        $addContact->execute(array(
            $_POST['firstname'],
            $_POST['lastname'],
            $_POST['email'],
            $_POST['label'],
            $_POST['message']
        ));

        return $addContact;
    }
}