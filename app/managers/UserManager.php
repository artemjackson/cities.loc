<?php

namespace App\Managers;

use App\Models\UserModel;

class UserManager
{
    public static function saveUser(array $userData = array())
    {
        $model = new UserModel();
        $userEmail = isset($userData['email']) ? $userData['email'] : null;
        
        if (false == $model->emailExists($userEmail)) { //TODO this should do Validator. Method saveUser only creates or updates user and doesn't validate data. And also it must return User class
            $model->saveUser($userData);
            return true;
        }

        return false;
    }

    //TODO if you are getting user by email so call this method getUserByEmail and pass $email to it
    public static function getUser(array $data = array())
    {
        $email = !empty($data['email']) ? $data['email'] : null;

        $model = new UserModel();
        return $model->getUserByEmail($email);
    }
}