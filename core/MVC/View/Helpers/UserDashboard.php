<?php

namespace Core\MVC\View\Helpers;

class UserDashboard extends AbstractHelper
{
    public function help()
    {
        if (!isset($this->session->loggedIn)) {
            return "";
        }

        $userData = $this->session->loggedIn->getData();

        $firstName = !empty($userData['firstName']) ? $userData['firstName'] : null;
        $lastName = !empty($userData['lastName']) ? $userData['lastName'] : null;

        if ($firstName && $lastName) {
            return $this->exportFrom(
                "user/dashboard",
                array(
                    'firstName' => $firstName,
                    'lastName' => $lastName
                )
            );
        }
        return null;
    }
}