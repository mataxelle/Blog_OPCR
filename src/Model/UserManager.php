<?php

namespace App\Model;

use App\BaseD\ConnectDB;
use App\Entity\User;
use DateTime;

class UserManager extends ConnectDB
{
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

    public function loginForm(User $user)
    {
        $db = $this->db;

        $login = $db->prepare('SELECT id, firstname, password FROM user WHERE email = ?');

        $login->execute(array(
            $user->getEmail()
        ));

        $result = $login->fetch();

        if (!$result) {

            echo 'Attention mauvais identifiant ou mot de passe !';
        }

        return $login;
    }
}