<?php

namespace App\Model;

use App\BaseD\ConnectDB;
use App\Entity\Contact;
use DateTime;
use PDO;

class ContactManager extends ConnectDB
{
    /**
     * Get all contact messages sorted by creation date
     *
     * @return array
     */
    public function getAllMessages()
    {
        $database = $this->database;

        $response = $database->query('SELECT * FROM contact ORDER BY createdAt ASC');

        return $response->fetchAll();
    }
    
    /**
     * Get a message by id
     *
     * @param  integer $id Contact message id
     * @return Contact
     */
    public function getOneMessage(int $id)
    {
        $database = $this->database;

        $response = $database->prepare('SELECT * FROM contact WHERE id = ?');

        $response->bindValue(1, $id, PDO::PARAM_INT);

        $response->execute([$id]);

        return new Contact($response->fetch());
    }
    
    /**
     * Insert a new contact message
     *
     * @return int
     */
    public function contactForm()
    {
        $database = $this->database;

        $addContact = $database->prepare('INSERT INTO contact (firstname, lastname, email, label, message, createdAt ) VALUES (?, ?, ?, ?, ?, ?)');

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

    /**
     * Delete a contact message
     *
     * @param  int $id Contact message id
     * @return void
     */
    public function deleteMessage(int $id)
    {
        $database = $this->database;

        $delete = $database->prepare('DELETE FROM contact WHERE id = ?');
        
        $delete->execute([$id]);
    }
}