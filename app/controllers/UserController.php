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
        if (!$this->getRequest()->isPost()) {
            if (null != $this->getSession()->get('user')) {
                $view->setTemplate("user/alreadyLogged");
            }
            return $view;
        }

        $data = $this->getRequest()->getPost();

        $form = new SingInForm($data);

        if ($form->isValid()) {
            $auth = new AuthManager();
            if ($auth->authenticate($data)) {
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
        if (null == $this->getSession()->get('user')) {
            $view->setTemplate("errors/404");
            return $view;
        }

        $this->session->remove('user');
        $this->redirect("home");
    }
}