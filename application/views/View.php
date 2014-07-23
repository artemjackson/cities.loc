<?php

namespace Application\Views;

use Core\AbstractView;

class View extends AbstractView
{
    public function __construct(array $data = array())
    {
        $this->setData($data);
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

    /**
     * @return null
     */
    public function getLayout()
    {
        return $this->layout;
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
    public function getTemplate()
    {
        return $this->template;
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
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    public function extractParams()
    {
        if (!empty($this->getData())) {
            foreach ($this->getData() as $key => $param) {
                $this->{$key} = $param;
            }
        }
    }

    public function getHtml()
    {
        $this->extractParams();
        ob_start();
        include 'application/views/' . $this->getTemplate() . '.phtml';
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function render()
    {
        $this->content = $this->getHtml();
        include 'application/views/layouts/' . $this->getLayout() . '.phtml';
    }
}