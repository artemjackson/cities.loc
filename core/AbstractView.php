<?php
namespace Core;

abstract class AbstractView
{
    abstract function generate($content_view, $template_view, $data = null);
}