<?php

namespace Application\Managers;

use Application\Models\RegistrationModel;

class RegistrationManager
{

    public static function addUser(array $userData = array())
    {
        $model = new RegistrationModel();

        $userEmail = $userData['email'];

        if ($model->findUserByEmail($userEmail) == false) {
            $model->addUser($userData);
            return true;
        }

        return false;
    }

}