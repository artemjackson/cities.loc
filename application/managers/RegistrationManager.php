<?php

namespace Application\Managers;

use Application\Models\RegistrationModel;

class RegistrationManager
{
   //TODO create method saveUser(array $data) and use it for update and create
    public static function addUser(array $userData = array())
    {
        $model = new RegistrationModel(); //TODO registration model wtf??? you need something like UserModel for that. Model must match a table or connected tables (so for User table should be UserModel). Read about ActiveRecord

        $userEmail = $userData['email']; //TODO check variable

        if ($model->findUserByEmail($userEmail) == false) {
            $model->addUser($userData);
            return true;
        }

        return false;
    }

}