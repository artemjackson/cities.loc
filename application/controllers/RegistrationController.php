<?php

namespace Application\Controllers;

use Application\Form\RegistrationForm;
use Application\Managers\RegistrationManager;
use Core\MVC\Controller\Controller;
use Core\MVC\View\View;


/**
 * Class RegistrationController
 * @package Application\Controllers
 */
class RegistrationController extends Controller
{
    /**
     * @return View
     */
    public function indexAction()
    {
        $view = new View();

        if (!$this->getRequest()->isPost()) {
            return $view;
        }

        $data = $this->getRequest()->getPost();

        $form = new RegistrationForm($data);

        if ($form->isValid()) {
            if (RegistrationManager::addUser($data)) {
                $message = "Congratulations! You have successfully registered!\n";
                $view->setData(
                    array(
                        'message' => $message,
                        'status' => 'success'
                    )
                );
            } else {
                $message = "Unfortunately this email is already in use.\n";
                $view->setData(
                    array(
                        'message' => $message,
                        'status' => 'success'
                    )
                );
            }
        } else {
            $message = $form->getMessage();
            $view->setData(
                array(
                    'message' => $message,
                    'status' => 'warning'
                )
            );
        }

        return $view;
    }
}