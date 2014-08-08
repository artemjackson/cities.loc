<?php

namespace Core\Session;

/**
 * Class Session
 * @package Core\Session
 */
class Session
{
    /**
     *
     */
    const SESSION_STARTED = true;
    /**
     *
     */
    const SESSION_NOT_STARTED = false;
    /**
     * @var bool
     */
    private static $sessionState = self::SESSION_NOT_STARTED;

    /**
     *
     */
    public function __construct()
    {
        $this->startSession();
    }

    /**
     * @return bool
     */
    public function startSession()
    {
        if (self::$sessionState === self::SESSION_NOT_STARTED) {
            self::$sessionState = session_start();
        }

        return self::$sessionState;
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

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * @param $name
     */
    public function __unset($name)
    {
        unset($_SESSION[$name]);
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($_SESSION[$name]);
    }

    /**
     * @return bool
     */
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