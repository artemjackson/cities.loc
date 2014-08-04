<?php

namespace Core;

use Core\Session\Session;

class Identifier
{
    const GUEST = 'quest';

    public static function identity()
    {
        $session = new Session();

        if (isset($session->loggedIn)) {
            $roles = array_keys($session->loggedIn->getRoles());
            return isset($roles[0]) ? $roles[0] : self::GUEST;
        }
        return self::GUEST;
    }
}