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
    
    public function contactForm($firstname, $lastname, $email, $label, $message)
    {
        $db = $this->db;

        $addContact = $db->prepare('INSERT INTO contact (firstname, lastname, email, label, message, created_at ) VALUES (?, ?, ?, ?, ?, ?)');

        $addContact->execute(array(
            $firstname,
            $lastname,
            $email,
            $label,
            $message,
            (new DateTime())->format('Y-m-d h:i:s')
        ));

        return $addContact;
    }
}