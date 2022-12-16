<?php

namespace App\Model;

use App\BaseD\ConnectDB;
use App\Entity\Contact;
use DateTime;
use PDO;

class ContactManager extends ConnectDB
{
    public function getAllMessages()
    {
        $db = $this->db;

        $response = $db->query('SELECT * FROM contact ORDER BY createdAt ASC');

        return $response->fetchAll();
    }

    public function getOneMessage(int $id)
    {
        $db = $this->db;

        $response = $db->prepare('SELECT * FROM contact WHERE id = ?');

        $response->bindValue(1, $id, PDO::PARAM_INT);

        $response->execute([$id]);

        return new Contact($response->fetch());
    }
    
    public function contactForm()
    {
        $db = $this->db;

        $addContact = $db->prepare('INSERT INTO contact (firstname, lastname, email, label, message, createdAt ) VALUES (?, ?, ?, ?, ?, ?)');

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

    public function deleteMessage(int $id)
    {
        $db = $this->db;

        $delete = $db->prepare('DELETE FROM contact WHERE id = ?');
        
        $delete->execute([$id]);
    }
}