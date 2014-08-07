<?php

namespace Core\MVC\View;

/**
 * Class JsonView
 * @package Core\MVC\View
 */
class AdminView extends View
{
    public function __construct(array $data = array()){
        parent::__construct($data);
        $this->setLayout('admin');
    }
}