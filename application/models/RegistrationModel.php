<?php

namespace Application\Models;

use Core\Database\Database;
use Core\MVC\Model\Model;

class RegistrationModel extends Model
{
    public function addUser(array $userData = array())
    {
        $firstName = $userData['first_name'];
        $secondName = $userData['second_name'];
        $email = $userData['email'];
        $password = $userData['password'];

        $query = array(
            'insertInto' => 'users',
            'columns' => array('first_name', 'second_name', 'email', 'password'),
            'values' => array($firstName, $secondName, $email, $password)
        );

        return Database::getConnection()->add($query);
    }

    public function findUserByEmail($email)
    {
        $query = array(
            'select' => '*',
            'from' => 'users',
            'where' => 'email',
            'whereValue' => $email,
        );

        return Database::getConnection()->get($query);
    }
}