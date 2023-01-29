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

        // End getAllMessages().
    }


    /**
     * Get a message by id
     *
     * @param  integer $messageId Contact message id
     * @return Contact
     */
    public function getOneMessage(int $messageId)
    {
        $database = $this->database;

        $response = $database->prepare('SELECT * FROM contact WHERE id = ?');

        $response->bindValue(1, $messageId, PDO::PARAM_INT);

        $response->execute();

        $fetch = $response->fetch();

        if (!$fetch) {
            return null;
        }
        
        return new Contact($fetch);
    }


    /**
     * Insert a new contact message
     *
     * @param Contact $contact Contact entity
     * @return int
     */
    public function contactForm(Contact $contact)
    {
        $database = $this->database;

        $addContact = $database->prepare('INSERT INTO contact (firstname, lastname, email, label, message, createdAt, isAnswered, answeredAt ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');

        $addContact->execute(
            [
             $contact->getFirstname(),
             $contact->getLastname(),
             $contact->getEmail(),
             $contact->getLabel(),
             $contact->getMessage(),
             (new DateTime())->format('Y-m-d h:i:s'),
             $contact->isAnswered() ? 1 : 0,
             (new DateTime())->format('Y-m-d h:i:s'),
            ]
        );

        return $addContact;
    }

    /**
     * Delete a contact message
     *
     * @param  int $messageId Contact message id
     * @return void
     */
    public function deleteMessage(int $messageId)
    {
        $database = $this->database;

        $delete = $database->prepare('DELETE FROM contact WHERE id = ?');
        
        $delete->execute([$messageId]);
    }
}
