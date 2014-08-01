<?php

namespace Core\Session;

/**
 * Class Session
 * @package Core\Session
 */
class Session
{
    const SESSION_STARTED = true;
    const SESSION_NOT_STARTED = false;
    private static $sessionState = self::SESSION_NOT_STARTED;

    public  function __construct()
    {
        $this->startSession();
    }

    /**
     *
     */
    public function __get($name)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
    }

    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function startSession()
    {
        if (self::$sessionState === self::SESSION_NOT_STARTED) {
            self::$sessionState = session_start();
        }

        return self::$sessionState;
    }

    public function __unset($name)
    {
        unset($_SESSION[$name]);
    }

    public function __isset($name)
    {
        return isset($_SESSION[$name]);
    }

    public function destroy()
    {
        if (self::$sessionState === self::SESSION_STARTED) {
            self::$sessionState = !session_destroy();
            unset($_SESSION);

            return !self::$sessionState;
        }

        return false;
    }
}