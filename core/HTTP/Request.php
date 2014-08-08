<?php

namespace Core\HTTP;

/**
 * Class Request
 * @package Core\HTTP
 */
class Request
{
    /**
     *
     */
    const GET = 'GET';
    /**
     *
     */
    const POST = 'POST';

    /**
     * @var null
     */
    protected $method = null;
    /**
     * @var null
     */
    protected $getParams = null;
    /**
     * @var null
     */
    protected $postParams = null;

    /**
     *
     */
    public function __construct()
    {
        $this->method = !empty($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null;
    }

    /**
     * @return bool
     */
    public function isGet()
    {
        return $this->method === self::GET;
    }

    /**
     * @return bool
     */
    public function isPost()
    {
        return $this->method === self::POST;
    }

    /**
     * @param null $name
     * @return null
     */
    public function getGet($name = null)
    {
        if ($this->getParams === null) {
            $this->getParams = $_GET;
        }

        if ($name !== null) {
            return $this->getParams[$name];
        }

        return $this->getParams;
    }

    /**
     * @param null $name
     * @return null
     */
    public function getPost($name = null)
    {
        if ($this->postParams === null) {
            $this->postParams = $_POST;
        }

        if ($name === null) {
            return $this->postParams;
        }

        return !empty($this->postParams[$name]) ? $this->postParams[$name] : null;
    }

    /**
     * @return bool
     */
    public function  isAjax()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }

    /**
     * @return null
     */
    public function getMethod()
    {
        return $this->method;
    }
}