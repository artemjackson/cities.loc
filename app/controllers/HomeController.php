<?php

namespace App\Controllers;

use App\Form\SingInForm;
use App\Managers\UserManager;
use Core\MVC\Controller\Controller;
use Core\MVC\View\View;

/**
 * Class HomeController
 * @package App\Controllers
 */
class HomeController extends Controller
{
    /**
     * @return View
     */
    public function indexAction()
    {
        $view = new View();

        if (!$this->getRequest()->isPost()) {
            if (null != $this->getSession()->get('user')) {
                $this->redirect("home/user");
            }
            return $view;
        }

        $data = $this->getRequest()->getPost();

        $form = new SingInForm($data);

        if ($form->isValid()) {
            if (UserManager::userExist($data)) {
                if (UserManager::checkPassword($data)) {

                    $userData = UserManager::getUser($data);
                    $firstName = $userData['first_name'];
                    $lastName = $userData['last_name'];
                    $this->getSession()->set(
                        'user',
                        array(
                            'firstName' => $firstName,
                            'lastName' => $lastName
                        )
                    );

                    $this->redirect("home/user");
                } else {
                    $this->flashMessager->addErrorMessage("Incorrect password!");
                }
            } else {
                $this->flashMessager->addWarningMessage("User with such email does not exist!\n");
            }
        } else {
            foreach ($form->getMessages() as $warningText) {
                $this->flashMessager->addWarningMessage($warningText);
            }
        }

        return $view;
    }

    public function userAction()
    {
        if ($this->getRequest()->isGet()){
            $get = $this->getRequest()->getGet();
            $action = !empty($get['action']) ? $get['action'] : null;

            if($action === 'logoff'){
                $this->session->remove('user');
                $this->redirect("home");
            }
        }

        $view = new View();
        if (null != $this->getSession()->get('user')) {
            $userData = $this->getSession()->get('user');
            $firstName = $userData['firstName'];
            $lastName = $userData['lastName'];
            $view->setData(array(
                'firstName' => $firstName,
                'lastName' => $lastName
            ));
        } else {
            $view->setTemplate("errors/404");
        }
        return $view;
    }
}