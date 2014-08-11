<?php

namespace App\Controllers;


use App\Form\RegistrationForm;
use App\Managers\UserManager;
use Core\Loggers\FileLogger\FileLogger;
use Core\MVC\Controller\Controller;
use Core\MVC\View\View;

/**
 * Class RegistrationController
 * @package App\Controllers
 */
class RegistrationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->logger = new FileLogger("registration_controller.log");
    }
    /**
     * @return View
     */
    public function indexAction()
    {
        $view = new View();
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $form = new RegistrationForm($data);
            if ($form->isValid()) {
                if (UserManager::saveUser($data)) {
                    $this->flashMessenger->addSuccessMessage("Congratulations! You have successfully registered!\n");
                    $this->getLogger()->log('New user ' . $data['first_name'] . ' ' . $data['last_name'] . ' successfully registered', FileLogger::SUCCESS);
                    $this->redirect('registration');
                } else {
                    $this->flashMessenger->addErrorMessage("Unfortunately this email is already in use!\n");
                }
            } else {
                $this->flashMessenger->addWarningMessages($form->getMessages());
            }
        }
        return $view;
    }
}