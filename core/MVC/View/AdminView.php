<?php

namespace Core\MVC\View;

//TODO it shouldnot be in a Core

/**
 * Class AdminView
 * @package Core\MVC\View
 */
class AdminView extends View
{
    /**
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->setLayout('admin');
    }
}