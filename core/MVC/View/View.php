<?php

namespace Core\MVC\View;

use Core\App;
use Core\Session\Session;

/**
 * Class View
 * @package Core\Views
 */
class View
{
    const SUCCESS = 'successMessages';
    const WARNING = 'warningMessages';
    const ERROR = 'errorMessages';
    protected $session;

    /**
     * @var
     */
    protected $data = array();

    /**
     * @var
     */
    protected $layout = null;

    /**
     * @var
     */
    protected $template;

    /**
     * @var
     */
    protected $html;

    /**
     *
     */
    public function __construct(array $data = array())
    {
        $this->session = new Session();
        $defaultLayout = App::getConfig('view', 'defaultLayout');

        $this->setLayout($defaultLayout);

        $this->setData($data);
    }

    public function __call($name, $arguments)
    {
        $helperName = __NAMESPACE__ . "\\Helpers\\" . ucfirst($name); //TODO what about checking is it exists or is it instance of HelperInterface for example
        $helper = new $helperName($arguments);
        return $helper->help();
    }

    //TODO seems to me I saw it in AbstractHelper. You are duplicating code
    public function exportFrom($path, array $data = array())
    {
        $html = null;
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
     *
     */
    public function render()
    {
        $layoutsPath = App::getConfig('view', 'layoutsPath');
        $layoutsExtension = App::getConfig('view', 'layoutsExtension');

        $this->setHtml($this->getHtml());
        include $layoutsPath . $this->getLayout() . $layoutsExtension;
    }

    /**
     * @return string
     */
    protected function getHtml()
    {
        return $this->exportFrom($this->getTemplate(), $this->getData());
    }

    /**
     * @param $html
     * @return $this
     */
    protected function setHtml($html)
    {
        $this->html = $html;
        return $this;
    }

    /**
     * @return null
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param null $template
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return null
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * @param null $layout
     * @return $this
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
        return $this;
    }
}