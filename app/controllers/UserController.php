<?php

namespace App\Controllers;

use App\Form\SingInForm;
use App\Managers\AuthManager;
use Core\MVC\Controller\Controller;
use Core\MVC\View\View;

/**
 * Class UserController
 * @package App\Controllers
 */
class UserController extends Controller
{
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
                $this->redirect("home");
            } else {
                $this->flashMessager->addErrorMessage($auth->getMessage());
            }
        } else {
            $this->flashMessager->addWarningMessages($form->getMessages());
        }
        return $view;
    }

    /**
     * @return View
     */
    public function logoutAction()
    {
        $view = new View();

        if (!isset($this->session->loggedIn)) {
            $view->setTemplate("errors/404");
            return $view;
        }

        unset($this->session->loggedIn);
        $this->redirect("home");
    }
}