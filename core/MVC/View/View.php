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

    }

    /**
     * @param $messagesType
     * @return string
     */
    public function flashMessages($messagesType)
    {
        $html = "";
        $session = new Session();
        if (isset($session->$messagesType)) {
            foreach ($session->$messagesType as $infoMessage) {
                $html .= $this->exportFrom(
                    "registration/message",
                    array(
                        'type' => $infoMessage->getType(),
                        'message' => $infoMessage->getMessage()
                    )
                );
            }
            unset($session->$messagesType);
        }
        return $html;
    }

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

    //TODO refactor
    public function adminDashboard()
    {

        if (!isset($this->session->loggedIn)) {
            return "";
        }

        if (!$this->session->loggedIn->hasRole('admin')) {
            return "";
        }

        return $this->exportFrom("admin/dashboard");

    }
//TODO refactor
    public function userField()
    {
        if (!isset($this->session->loggedIn)) {
            return "";
        }

        $userData = $this->session->loggedIn->getData();

        $firstName = !empty($userData['firstName']) ? $userData['firstName'] : null;
        $lastName = !empty($userData['lastName']) ? $userData['lastName'] : null;

        if ($firstName && $lastName) {
            return $this->exportFrom(
                "user/userField",
                array(
                    'firstName' => $firstName,
                    'lastName' => $lastName
                )
            );
        }
        return null;
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