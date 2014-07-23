<?php

namespace Application\Views;

use Core\AbstractView;

class JsonView extends View
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
    }

    public function render()
    {
        echo json_encode(array('html' => $this->getHtml()));
    }
}