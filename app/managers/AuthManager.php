<?php

namespace App\Managers;

use Core\Session\Session;
use Core\User\User;

/**
 * Class AuthManager
 * @package App\Managers
 */
class AuthManager
{
    /**
     * @var
     */
    protected $message;

    /**
     * @return mixed
     */
    public function getMessage() // TODO Is it only error message? Then call it getError to clarify what message
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function authenticate(array $data = array())
    {
        $userData = UserManager::getUser($data);

        if (null == $userData) {
            $this->setMessage("No user with such email has been found!");
            return false;
        }

        $hash = $userData['password'];
        $password = $data['password'];

        $valid = password_verify($password, $hash); //TODO use password manager for that

        if ($valid) {
            /* getting user and it's properties*/
            $user = new User();
            $user->setData(
                array(
                    'id' => $userData['user_id'],
                    'firstName' => $userData['first_name'],
                    'lastName' => $userData['last_name']
                )
            );
            $user->initRoles();

            /* user registration at the session */
            $session = new Session();
            $session->loggedIn = $user;

            return true;
        } else {
            $this->setMessage("Incorrect password!");
            return false;
        }
    }
}