<?php

namespace Core\MVC\View\Helpers;

use Core\App;
use Core\Session\Session;

/**
 * Class AbstractHelper
 * @package Core\MVC\View\Helpers
 */
abstract class AbstractHelper implements HelperInterface
{
    /**
     * @var \Core\Session\Session
     */
    protected $session;
    /**
     * @var array
     */
    protected $data = array();

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        $this->setData($data);
        $this->session = new Session();
    }

    /**
     * @return mixed
     */
    abstract public function help();

    /**
     * @param $path
     * @param array $data
     * @return string
     */
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

    /**
     * @return string
     */
    public function currentPage()
    {
        $rout = explode("/",$_SERVER['REQUEST_URI']);
        $number = count($rout);
        return ucfirst($rout[$number-2]) ? : 'Home';
    }
}