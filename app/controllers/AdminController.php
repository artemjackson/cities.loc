<?php

namespace App\Controllers;

use Core\Identifier\Identifier;
use Core\Loggers\FileLogger\FileLogger;
use Core\MVC\Controller\Controller;
use Core\MVC\View\AdminView;
use Core\MVC\View\View;

/**
 * Class HomeController
 * @package App\Controllers
 */
class AdminController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->logger = new FileLogger("admin_controller.log");
    }

    /**
     * @return View
     */
    public function indexAction()
    {
        return Identifier::isAdmin() ? new AdminView() : $this->accessForbidden();
    }

    //TODO refactor move to routers config
    /**
     * @param $name
     * @param array $arguments
     * @return $this
     */
    public function __call($name, array $arguments = array())
    {
        if (!Identifier::isAdmin()) {
            return $this->accessForbidden();
        }

        $helperName = __NAMESPACE__ . "\\Helpers\\" . ucfirst($name) . "Controller";

        try {
            $helper = new $helperName();
        } catch (\AutoloaderException $e) {
            $this->getLogger()->log("Undefined helper '$name'' was called");
            return $this->notFound();
        }

        $action = isset($arguments[0][0]) ? $arguments[0][0] : 'index';
        unset($arguments[0][0]);
        $args = isset($arguments[0][1]) ? $arguments[0][1] : null;

        if (method_exists($helper, $action)) {
            return $helper->$action($args);
        } else {
            $this->getLogger()->log("Undefined action '$action' of '$name' helper was called");
            return $this->notFound();
        }
    }
}