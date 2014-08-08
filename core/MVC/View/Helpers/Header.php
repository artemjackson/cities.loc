<?php

namespace Core\MVC\View\Helpers;

use Core\App;

/**
 * Class Header
 * @package Core\MVC\View\Helpers
 */
class Header extends AbstractHelper
{
    /**
     *
     */
    public function help()
    {
        include App::getConfig('view', 'templatesPath') . "header.phtml";
    }

    /**
     * @return string
     */
    public function headerTitle()
    {
        $currentPage = $this->currentPage();
        return "<title>Cities.loc:  $currentPage</title>";
    }
}
