<?php

namespace App\Models;

use Core\Db\Db;
use Core\MVC\Model\Model;

class UserModel extends Model
{
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

    public function findUserByEmail($email)
    {
        $query = array(
            'select' => '*',
            'from' => 'users',
            'where' => 'email',
            'whereValue' => $email,
        );

        return Db::getConnection()->get($query);
    }

    public function checkUserPassword($email, $password)
    {
        $query = array(
            'select' => 'password',
            'from' => 'users',
            'where' => 'email',
            'whereValue' => $email,
        );

        $result = Db::getConnection()->get($query);
        $hash = $result[0]['password'];

        return true === password_verify($password, $hash) ;
    }

    public function getUserByEmail($email)
    {
        $query = array(
            'select' => 'first_name, last_name',
            'from' => 'users',
            'where' => 'email',
            'whereValue' => $email,
        );

        $result = Db::getConnection()->get($query);
        return $result[0];
    }
}