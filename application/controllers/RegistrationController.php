<?php

namespace Application\Controllers;


use Application\Form\RegistrationForm;
use Application\Managers\FlashMessagesManager;
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
     * @var \Application\Managers\FlashMessagesManager
     */
    protected $flashMessagesManager;

    /**
     *
     */
    public function __construct()
    {
        $this->flashMessagesManager = new FlashMessagesManager();
    }

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
                $this->flashMessagesManager->addSuccessMessage();

            } else {
                $this->flashMessagesManager->addErrorMessage();
            }
        } else {
            foreach ($form->getMessages() as $warningText) {
                $this->flashMessagesManager->addWarningMessage($warningText);
            }
        }

        return $view;
    }
}