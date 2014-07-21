<?php
namespace Application\Views;

use Core\AbstractView;

class IndexView extends AbstractView
{
    public function generate($contentView, $templateView = null, $data = null)
    {
        if (!$templateView) {
            $templateView = 'template.php';
        }
        include 'application/views/layouts/' . $templateView;
    }
}