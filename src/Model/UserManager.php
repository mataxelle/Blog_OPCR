<?php

namespace App\Model;

use App\BaseD\ConnectDB;
use App\Entity\User;
use DateTime;
use PDO;

class UserManager extends ConnectDB
{
    /**
     * Get all users sorted by creation date
     *
     * @return array
     */
    public function getAllUsers()
    {
        $database = $this->database;

        $response = $database->query('SELECT * FROM user ORDER BY createdAt DESC');

        return $response->fetchAll();
    }
    
    /**
     * Get a user by id
     *
     * @param  int $id
     * @return User
     */
    public function getUser(int $id)
    {
        $database = $this->database;

        $response = $database->prepare('SELECT * FROM user WHERE id = ?');

        $response->bindValue(1, $id, PDO::PARAM_INT);

        $response->execute();

        return new User($response->fetch());
    }

    /**
     * Register a new user
     * 
     * @return int
     */
    public function registerForm(User $user)
    {
        $database = $this->database;

        $createUser = $database->prepare('INSERT INTO user (firstname, lastname, isAdmin, email, password, createdAt, updatedAt) VALUES (?, ?, ?, ?, ?, ?, ?)');

        $pass_hache = password_hash($user->getPassword(), PASSWORD_DEFAULT);

        $createUser->execute(array(
            $user->getFirstname(),
            $user->getLastname(),
            $user->getIsAdmin() ? 1 : 0,
            $user->getEmail(),
            $pass_hache,
            (new DateTime())->format('Y-m-d h:i:s'),
            (new DateTime())->format('Y-m-d h:i:s')
        ));

        return $createUser;
    }

    /**
     * Log a user by id
     * 
     * @param strin $email User email
     * @return User
     */
    public function loginForm(string $email)
    {
        $database = $this->database;

        $login = $database->prepare('SELECT * FROM user WHERE email = ?');

        $login->bindValue(1, $email, PDO::PARAM_STR);

        $login->execute();
        
        return new User($login->fetch());
    }

    /**
     * Insert a new post
     * 
     * @param int $id
     * @return void
     */
    public function deleteUser(int $id)
    {
        $database = $this->database;

        $delete = $database->prepare('DELETE FROM user WHERE id = ?');
        
        $delete->execute([$id]);
    }
}