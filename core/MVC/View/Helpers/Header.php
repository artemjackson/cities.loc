<?php

namespace Core\MVC\View\Helpers;

use Core\App;

class Header extends AbstractHelper
{


    public function help()
    {
        include App::getConfig('view', 'templatesPath') . "header.phtml";
    }

    public function headerTitle()
    {
        $currentPage = $this->currentPage();
        return "<title>Cities.loc:  . $currentPage</title>";
    }

    public function currentPage()
    {
        $rout = $_SERVER['REQUEST_URI'];
        return ucfirst(explode('/', $rout)[1]) ? : 'Home';
    }
}
