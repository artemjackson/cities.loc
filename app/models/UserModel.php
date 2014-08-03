<?php

namespace App\Models;

use Core\Db\Db;
use Core\MVC\Model\Model;

/**
 * Class UserModel
 * @package App\Models
 */
class UserModel extends Model
{
    /**
     * @param array $userData
     * @return bool
     */
    public function saveUser(array $userData = array())
    {
        $firstName = !empty($userData['first_name']) ? $userData['first_name'] : null;
        $lastName = !empty($userData['last_name']) ? $userData['last_name'] : null;
        $email = !empty($userData['email']) ? $userData['email'] : null;

        // hashing password
        $password = password_hash($userData['password'], PASSWORD_DEFAULT); //TODO this must do PasswordManager. ( $passwordManager->hash($password) // something like that)

        $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";

        Db::prepare($sql);
        return Db::execute(
            array(
                ':first_name' => $firstName,
                ':last_name' => $lastName,
                ':email' => $email,
                ':password' => $password
            )
        );
    }

    /**
     * @param $email
     * @return bool
     */
    public function emailExists($email)
    {
        $sql = "SELECT user_id FROM users WHERE email = :email";

        Db::prepare($sql);

        return Db::execute(array(':email' => $email));
    }

    /**
     * @param $email
     * @return null
     */
    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";

        Db::prepare($sql);
        $result = Db::execute(array(':email' => $email));
        return !empty($result[0]) ? $result[0] : null;
    }
}