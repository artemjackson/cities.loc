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
    public function __construct()
    {
        if (!session_id()) {
            session_start();
        }
    }

     /**
     * @param $id
     * @return null
     */
    public function get($id)
    {
        return !empty($_SESSION[$id]) ? $_SESSION[$id] : null;
    }

    /**
     * @param $id
     * @return $this
     */
    public function remove($id)
    {
        if (!empty($_SESSION[$id])) {
            unset($_SESSION[$id]);
        }
        return $this;
    }

    /**
     * @param $id
     * @param $data
     * @return $this
     */
    public function set($id, $data)
    {
        if (!empty($_SESSION[$id]) && is_array($_SESSION[$id])) {
            $_SESSION[$id][] = $data;
        } else {
            $_SESSION[$id] = $data;
        }
        return $this;
    }

    /**
     * @param $id
     * @param $data
     * @return $this
     */
    public function addToArray($id, $data)
    {
        $_SESSION[$id][] = $data;
        return $this;
    }


    /**
     * @param $id
     * @return bool
     */
    public function isEmpty($id)
    {
        return empty($_SESSION[$id]);
    }
}