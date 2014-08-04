<?php

namespace Core\MVC\View\Helpers;

use Core\App;

class Footer extends AbstractHelper
{
    public function help()
    {
        include App::getConfig('view', 'templatesPath') . "footer.phtml";
    }
}