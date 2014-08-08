<?php

namespace Core\Identifier;

use Core\Session\Session;

/**
 * Class Identifier
 * @package Core\Identifier
 */
class Identifier
{
    /**
     *
     */
    const ADMIN = 'admin';
    /**
     *
     */
    const GUEST = 'quest';

    /**
     * @return bool
     */
    public static function isAdmin()
    {
        return self::ADMIN === self::identity();
    }

    /**
     * @return string
     */
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