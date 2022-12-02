<?php

namespace App\Model;

use App\BaseD\ConnectDB;
use App\Entity\User;
use DateTime;

class UserManager extends ConnectDB
{
    public function getAllUsers()
    {
        $db = $this->db;

        $response = $db->query('SELECT * FROM user ORDER BY created_at DESC');

        return $response->fetchAll();  
    }

    public function getUser(int $id)
    {
        $db = $this->db;

        $response = $db->prepare('SELECT * FROM user WHERE id = ?');

        $response->execute([$id]);

        return $response->fetch();  
    }

    public function registerForm(User $user)
    {
        $db = $this->db;

        $createUser = $db->prepare('INSERT INTO user (firstname, lastname, is_admin, email, password, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)');

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

    public function loginForm()
    {
        $db = $this->db;

        $login = $db->prepare('SELECT * FROM user WHERE email = ?');

        $login->execute(array(
            $_POST['email'],
        ));

        $result = $login->fetch();
        
        return $result;
    }

    public function deleteUser(int $id)
    {
        $db = $this->db;

        $delete = $db->prepare('DELETE FROM user WHERE id = ?');
        
        $delete->execute([$id]);
    }
}