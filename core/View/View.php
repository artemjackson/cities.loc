<?php

namespace Core\View;

use Core\Application;
use Core\Exceptions\ConfigurationException;

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
        $configuration = Application::getConfiguration()['VIEW_CONFIGURATION'];
        if (!$configuration) {
            throw new ConfigurationException('No configuration were specified for ' . __CLASS__);
        }
        $this->setConfiguration($configuration);

        $this->setData($data);
    }

    /**
     * @param array $configuration
     * @return $this
     */
    protected function setConfiguration(array $configuration = array())
    {
        // Creating variables into class
        foreach ($configuration as $key => $value) {
            $this->$key = $value;
        }

        $this->setLayout($this->defaultLayout);

        return $this;
    }

    /**
     *
     */
    public function render()
    {
        $this->html = $this->getHtml();
        include $this->layoutsPath . $this->getLayout() . $this->layoutExtension;
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        /*
         * Extracting variables from $this->data
         */
        extract($this->getData());

        ob_start();
        include $this->templatesPath . $this->getTemplate() . $this->templatesExtension;
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    /**
     * @param mixed $html
     */
    public function setHtml($html)
    {
        $this->html = $html;
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