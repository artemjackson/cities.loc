<?php

namespace App\Managers;

use App\Models\UserModel;

class UserManager
{
    public static function saveUser(array $userData = array())
    {
        $model = new UserModel();
        $userEmail = isset($userData['email']) ? $userData['email'] : null;

        if (false == $model->findUserByEmail($userEmail)) {
            $model->saveUser($userData);
            return true;
        }

        return false;
    }

    public static function userExist(array $userData = array())
    {
        $model = new UserModel();
        $userEmail = isset($userData['email']) ? $userData['email'] : null;

        return $model->findUserByEmail($userEmail);
    }

    public static function checkPassword(array $data = array())
    {
        $email = !empty($data['email']) ? $data['email'] : null;
        $password = !empty($data['password']) ? $data['password'] : null;

        $model = new UserModel();
        return $model->checkUserPassword($email, $password);
    }

    public static function getUser(array $data = array())
    {
        $email = !empty($data['email']) ? $data['email'] : null;

        $model = new UserModel();
        return $model->getUserByEmail($email);
    }
}