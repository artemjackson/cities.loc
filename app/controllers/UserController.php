<?php

namespace App\Controllers;

use App\Form\SingInForm;
use App\Managers\AuthManager;
use Core\Loggers\FileLogger\FileLogger;
use Core\MVC\Controller\Controller;
use Core\MVC\View\View;

/**
 * Class UserController
 * @package App\Controllers
 */
class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->logger = new FileLogger("user_controller.log");
    }
    /**
     * @return View
     */
    public function loginAction()
    {
        $view = new View();
        if (!$this->getRequest()->isPost()) { //TODO what about if user logged in and send POST request?
            if (isset($this->session->loggedIn)) {
                $this->redirect("home");
            }
            return $view;
        }

        $data = $this->getRequest()->getPost();

        $form = new SingInForm($data);

        if ($form->isValid()) {
            $auth = new AuthManager();
            if ($auth->authenticate($data)) { // TODO this method should take only email and password not array with params
                $this->getLogger()->log('User entered', FileLogger::SUCCESS); // IT'S A TEMPORARY SOLUTION: $data['first_name'] . $data['last_name']
                $this->redirect("home");
            } else {
                $this->flashMessenger->addErrorMessage($auth->getMessage());
            }
        } else {
            $this->flashMessenger->addWarningMessages($form->getMessages());
        }
        return $view;
    }

    /**
     * @return View
     */
    public function logoutAction()
    {
        if (!isset($this->session->loggedIn)) {
            return $this->notFound();
        }

        unset($this->session->loggedIn);
        $this->getLogger()->log('User exited');
        $this->redirect("home");
    }
}