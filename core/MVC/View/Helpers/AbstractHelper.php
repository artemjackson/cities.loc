<?php

namespace Core\MVC\View\Helpers;

use Core\App;
use Core\Session\Session;

abstract class AbstractHelper implements HelperInterface
{
    protected $session;
    protected $data = array();

    public function __construct(array $data = array())
    {
        $this->session = new Session();
    }

    abstract public function help();

    public function exportFrom($path, array $data = array())
    {
        $html = "";
        $templatesPath = App::getConfig('view', 'templatesPath');
        $templatesExtension = App::getConfig('view', 'templatesExtension');

        $file = $templatesPath . $path . $templatesExtension;

        if (file_exists($file)) {
            extract($data);
            ob_start();
            include $file;
            $html .= ob_get_contents();
            ob_end_clean();
        }
        return $html;
    }
}