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
     */
    public function contactForm(Contact $contact)
    {
        $database = $this->database;

        $addContact = $database->prepare('INSERT INTO contact (firstname, lastname, email, label, message, createdAt, isAnswered, answeredAt ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');

        $addContact->execute(array(
            $contact->getFirstname(),
            $contact->getLastname(),
            $contact->getEmail(),
            $contact->getLabel(),
            $contact->getMessage(),
            (new DateTime())->format('Y-m-d h:i:s'),
            $contact->getIsAnswered() ? 1 : 0,
            $contact->getAnsweredAt()
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