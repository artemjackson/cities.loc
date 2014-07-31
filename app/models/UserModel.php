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
        $password = password_hash($userData['password'], PASSWORD_DEFAULT);

        //TODO your query builder is difficult to understand
        //  What should I do whit this?
        $query = array(
            'insertInto' => 'users',
            'columns' => array('first_name', 'last_name', 'email', 'password'),
            'values' => array($firstName, $lastName, $email, $password)
        );

        return Db::getConnection()->add($query);
    }

    /**
     * @param $email
     * @return bool
     */
    public function emailExists($email)
    {
        $query = array(
            'select' => 'email',
            'from' => 'users',
            'where' => 'email',
            'whereValue' => $email,
        );

        return !is_null(Db::getConnection()->get($query));
    }

    /**
     * @param $email
     * @return null
     */
    public function getUserByEmail($email)
    {
        $query = array(
            'select' => '*',
            'from' => 'users',
            'where' => 'email',
            'whereValue' => $email,
        );

        $result = Db::getConnection()->get($query);
        return !empty($result[0]) ? $result[0] : null;
    }
}