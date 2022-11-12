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

    public function loginForm($email, $password)
    {
        $db = $this->db;

        $login = $db->prepare('INSERT INTO user (email, password) VALUES (?, ?)');

        $login->execute(array(
            $email,
            $password,
        ));

        return $login;
    }
}