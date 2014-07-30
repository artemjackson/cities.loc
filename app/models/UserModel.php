<?php

namespace App\Models;

use Core\Db\Db;
use Core\MVC\Model\Model;

class UserModel extends Model
{
    public function saveUser(array $userData = array())
    {
        $firstName = !empty($userData['first_name']) ? $userData['first_name'] : null;
        $secondName = !empty($userData['second_name']) ? $userData['second_name'] : null;
        $email = !empty($userData['email']) ? $userData['email'] : null;

        // hashing password
        $password = password_hash($userData['password'], PASSWORD_DEFAULT);

        //TODO your query builder is difficult to understand
        //  What should I do whit this?
        $query = array(
            'insertInto' => 'users',
            'columns' => array('first_name', 'second_name', 'email', 'password'),
            'values' => array($firstName, $secondName, $email, $password)
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
}