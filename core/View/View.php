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
    protected $html;

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
     * @var array
     */
    protected static $configuration;

    /**
     *
     */
    public function __construct(array $data = array())
    {
        /*
         * Configuration is the same for all Views
         */
        if(is_null(self::$configuration)){
            $conf = Application::getConfiguration()['VIEW_CONFIGURATION'];
            if (!$conf) {
                throw new ConfigurationException('No configuration were specified for ' . __CLASS__);
            }
            $this->setConfiguration($conf);
        }
        $this->setData($data);
    }

    /**
     * @param array $configuration
     * @return $this
     */
    protected function setConfiguration($configuration)
    {
        self::$configuration = $configuration;

        // Creating variables into class
        foreach($configuration as $key => $value) {
            $this->$key = $value;
        }

        $this->setLayout($this->DEFAULT_LAYOUT);

        return $this;
    }

    /**
     *
     */
    public function render()
    {
        $this->html = $this->getHtml();
        include $this->LAYOUTS_PATH . $this->getLayout() . $this->LAYOUT_EXTENSION;
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
        include $this->TEMPLATES_PATH . $this->getTemplate() . $this->TEMPLATES_EXTENSION;
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