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
                $this->flashMessager->addSuccessMessage("Congratulations! You have successfully registered!\n");
                //$this->redirect('registration');
            } else {
                $this->flashMessager->addErrorMessage("Unfortunately this email is already in use!\n");
            }
        } else {
            foreach ($form->getMessages() as $warningText) {
                $this->flashMessager->addWarningMessage($warningText);
            }
        }
        return $view;
    }
}