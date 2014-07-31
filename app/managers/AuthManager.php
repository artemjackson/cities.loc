<?php

namespace App\Managers;

use Core\Session\Session;

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
    public function getMessage()
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

        $valid = password_verify($password, $hash);

        if ($valid) {
            $firstName = $userData['first_name'];
            $lastName = $userData['last_name'];

            $id = $userData['id'];

            $session = new Session();
            $session->set(
                'user',
                array(
                    'id' => $id,
                    'firstName' => $firstName,
                    'lastName' => $lastName
                )
            );
            return true;
        } else {
            $this->setMessage("Incorrect password!");
            return false;
        }
    }
}