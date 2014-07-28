<?php

namespace Core\MVC\View;

use Core\Application;

/**
 * Class View
 * @package Core\Views
 */
class View
{
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
        $defaultLayout = Application::getConfiguration('view', 'defaultLayout');

            $this->setLayout($defaultLayout);

        $this->setData($data);
    }

    /**
     *
     */
    public function render()
    {
        $layoutsPath = Application::getConfiguration('view', 'layoutsPath');
        $layoutsExtension = Application::getConfiguration('view', 'layoutsExtension');

        $this->setHtml($this->getHtml());
        include $layoutsPath . $this->getLayout() . $layoutsExtension;
    }

    /**
     * @return string
     */
    protected function getHtml()
    {
        $templatesPath = Application::getConfiguration('view','templatesPath');
        $templatesExtension = Application::getConfiguration('view','templatesExtension');

        /*
         * Extracting variables from $this->data
         */
        extract($this->getData());

        ob_start();
        include $templatesPath . $this->getTemplate() . $templatesExtension;
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
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