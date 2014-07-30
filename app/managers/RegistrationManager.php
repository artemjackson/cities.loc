<?php

namespace App\Managers;

use App\Models\UserModel;

class RegistrationManager
{
    public static function saveUser(array $userData = array())
    {
        $model = new UserModel();
        $userEmail = isset($userData['email']) ? $userData['email'] : null;

        if ($model->findUserByEmail($userEmail) == false) {
            $model->saveUser($userData);
            return true;
        }

        return false;
    }

}