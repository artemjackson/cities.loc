<?php

namespace Core\MVC\View\Helpers;

use Core\App;

abstract class AbstractPagination extends AbstractHelper
{
    protected $page;
    protected $allowed;

    public function  __construct(array $data = array())
    {
        parent::__construct($data);
        $this->setPage($this->currentPage());
        $this->setAllowed(5);

    }

    public function currentPage()
    {
        $rout = explode("/", $_SERVER['REQUEST_URI']);
        $number = count($rout);
        return $rout[$number - 1];
    }

    /**
     * @return mixed
     */
    public function getAllowed()
    {
        return $this->allowed;
    }

    /**
     * @param mixed $allowed
     */
    public function setAllowed($allowed)
    {
        $this->allowed = $allowed;
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    public function help()
    {
        include App::getConfig('view', 'templatesPath') . "pagination.phtml";
    }

    abstract public function pagination();
}