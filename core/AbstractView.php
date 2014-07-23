<?php
namespace Core;

abstract class AbstractView
{
    abstract public function __construct(array $data = array());

    abstract function render();

    protected $template = null;
    protected $layout = 'layout';
    protected $data = array();
}