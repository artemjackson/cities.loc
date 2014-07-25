<?php

namespace Core\View;

/**
 * Class JsonView
 * @package Core\View
 */
class JsonView extends View
{
    /**
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        parent::__construct($data);
    }

    /**
     *
     */
    public function render()
    {
        echo json_encode(array('html' => $this->getHtml()));
    }
}