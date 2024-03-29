<?php

namespace App\Model;

use App\BaseD\ConnectDB;
use App\Entity\User;
use DateTime;
use PDO;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
        // End getAllUsers().
    }


    /**
     * Get a user by id
     *
     * @param  int $userId User id
     * @return User
     */
    public function getUser(int $userId)
    {
        $database = $this->database;

        $response = $database->prepare('SELECT * FROM user WHERE id = ?');

        $response->bindValue(1, $userId, PDO::PARAM_INT);

        $response->execute();

        $fetch = $response->fetch();

        if (!$fetch) {
            return null;
        }

        return new User($fetch);

        //return new User($response->fetch());
    }

    /**
     * Register a new user
     *
     * @param User $user User entity
     * @return int
     */
    public function registerForm(User $user)
    {
        $database = $this->database;

        if ($user->getFirstname()) {

            if (!preg_match("#[a-zA-ZÀ-ÿ]#", $user->getFirstname())) {
                $res = new RedirectResponse('/register');
                $res->send();
                return false;
            }
        }

        if ($user->getLastname()) {

            if (!preg_match("#[a-zA-ZÀ-ÿ]#", $user->getLastname())) {
                $res = new RedirectResponse('/register');
                $res->send();
                return false;
            }
        }

        if ($user->getEmail()) {

            if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}#", $user->getEmail())) {
                $res = new RedirectResponse('/register');
                $res->send();
                return false;
            }
        }

        if ($user->getPassword()) {

            if (!preg_match("#[a-zA-Z0-9._?%$-]#", $user->getPassword())) {
                $res = new RedirectResponse('/register');
                $res->send();
                return false;
            }
        }

        $createUser = $database->prepare('INSERT INTO user (firstname, lastname, isAdmin, email, password, createdAt, updatedAt) VALUES (?, ?, ?, ?, ?, ?, ?)');

        $pass_hache = password_hash($user->getPassword(), PASSWORD_DEFAULT);

        $createUser->execute(
            [
                $user->getFirstname(),
                $user->getLastname(),
                $user->isAdmin() ? 1 : 0,
                $user->getEmail(),
                $pass_hache,
                (new DateTime())->format('Y-m-d h:i:s'),
                (new DateTime())->format('Y-m-d h:i:s'),
            ]
        );

        return $createUser;
    }

    /**
     * Log a user by email
     *
     * @param string $email User email
     * @return User
     */
    public function getUserByEmail(string $email)
    {
        $database = $this->database;

        $login = $database->prepare('SELECT * FROM user WHERE email = ?');

        $login->bindValue(1, $email, PDO::PARAM_STR);

        $login->execute();

        $fetch = $login->fetch();

        if (!$fetch) {
            return null;
        }

        return new User($fetch);
    }

    /**
     * Update account
     *
     * @param User $user User Entity
     * @return void
     */
    public function updateForm(User $user)
    {
        $database = $this->database;

        $upUser = $database->prepare('UPDATE user SET firstname = ?, lastname = ?, email = ?, updatedAt = ? WHERE id = ?');

        $upUser->bindValue(1, $user->getFirstname(), PDO::PARAM_STR);
        $upUser->bindValue(2, $user->getLastname(), PDO::PARAM_STR);
        $upUser->bindValue(3, $user->getEmail(), PDO::PARAM_STR);
        $upUser->bindValue(4, (new DateTime())->format('Y-m-d h:i:s'));
        $upUser->bindValue(5, $user->getId(), PDO::PARAM_INT);

        $upUser->execute();
    }

    /**
     * Delete a user
     *
     * @param int $userId User id
     * @return void
     */
    public function deleteUser(int $userId)
    {
        $database = $this->database;

        $delete = $database->prepare('DELETE FROM user WHERE id = ?');

        $delete->execute([$userId]);
    }
}
