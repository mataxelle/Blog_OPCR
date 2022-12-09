<?php

namespace App\Model;

use App\BaseD\ConnectDB;
use App\Entity\User;
use DateTime;
use PDO;

class UserManager extends ConnectDB
{
    public function getAllUsers()
    {
        $db = $this->db;

        $response = $db->query('SELECT * FROM user ORDER BY createdAt DESC');

        return $response->fetchAll();  
    }

    public function getUser(int $id)
    {
        $db = $this->db;

        $response = $db->prepare('SELECT * FROM user WHERE id = ?');

        $response->bindValue(1, $id, PDO::PARAM_INT);

        $response->execute();

        return new User($response->fetch());  
    }

    public function registerForm(User $user)
    {
        $db = $this->db;

        $createUser = $db->prepare('INSERT INTO user (firstname, lastname, isAdmin, email, password, createdAt, updatedAt) VALUES (?, ?, ?, ?, ?, ?, ?)');

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

    public function loginForm(string $email)
    {
        $db = $this->db;

        $login = $db->prepare('SELECT * FROM user WHERE email = ?');

        $login->bindValue(1, $email, PDO::PARAM_STR);

        $login->execute();
        
        return new User($login->fetch());
    }

    public function deleteUser(int $id)
    {
        $db = $this->db;

        $delete = $db->prepare('DELETE FROM user WHERE id = ?');
        
        $delete->execute([$id]);
    }
}