<?php

namespace App\Managers;

use App\Models\UserModel;

class UserManager
{
    public static function saveUser(array $userData = array())
    {
        $model = new UserModel();
        $userEmail = isset($userData['email']) ? $userData['email'] : null;
        
        if (false == $model->emailExists($userEmail)) {
            $model->saveUser($userData);
            return true;
        }

        return false;
    }

    public static function getUser(array $data = array())
    {
        $email = !empty($data['email']) ? $data['email'] : null;

        $model = new UserModel();
        return $model->getUserByEmail($email);
    }
}