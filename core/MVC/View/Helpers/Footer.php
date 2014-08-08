<?php

namespace Core\MVC\View\Helpers;

use Core\App;

/**
 * Class Footer
 * @package Core\MVC\View\Helpers
 */
class Footer extends AbstractHelper
{
    /**
     *
     */
    public function help()
    {
        include App::getConfig('view', 'templatesPath') . "footer.phtml";
    }
}