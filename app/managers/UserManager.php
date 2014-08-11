<?php

namespace App\Managers;

use App\Models\UserModel;

/**
 * Class UserManager
 * @package App\Managers
 */
class UserManager
{
    /**
     * @param array $userData
     * @return bool
     */
    public static function saveUser(array $userData = array())
    {
        $model = new UserModel();
        $userEmail = isset($userData['email']) ? $userData['email'] : null;

        if (false == $model->emailExists($userEmail)) { //TODO this should do Validator. Method saveUser only creates or updates user and doesn't validate data. And also it must return User class
            return $model->saveUser($userData);
        }
        return false;
    }

    /**
     * @return mixed
     */
    public static function getAllUsers()
    {
        $model = new UserModel();
        return $model->getAllUsers();
    }

    //TODO if you are getting user by email so call this method getUserByEmail and pass $email to it
    /**
     * @param array $data
     * @return null
     */
    public static function getUser(array $data = array())
    {
        $email = !empty($data['email']) ? $data['email'] : null;

        $model = new UserModel();
        return $model->getUserByEmail($email);
    }
}