<?php

namespace App\Model;

use App\BaseD\ConnectDB;
use DateTime;

class ContactManager extends ConnectDB
{
    public function getAllPost()
    {
        $db = $this->db;

        $response = $db->query('SELECT * FROM post ORDER BY created_at DESC');

        return $response;
    }
    
    public function contactForm()
    {
        $db = $this->db;

        $addContact = $db->prepare('INSERT INTO contact (firstname, lastname, email, label, message, created_at ) VALUES (?, ?, ?, ?, ?, ?)');

        $addContact->execute(array(
            $_POST['firstname'],
            $_POST['lastname'],
            $_POST['email'],
            $_POST['label'],
            $_POST['message'],
            (new DateTime())->format('Y-m-d h:i:s')
        ));

        return $addContact;
    }
}