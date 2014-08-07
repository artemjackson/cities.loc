<?php

namespace Core\MVC\View;

/**
 * Class JsonView
 * @package Core\MVC\View
 */
class JsonView extends View
{
    /**
     *
     */
    public function render()
    {
        echo json_encode(array('html' => $this->getHtml()));

    }
}