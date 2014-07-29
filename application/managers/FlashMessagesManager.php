<?php

namespace Application\Managers;

use Core\Message\Message;

/**
 * Class FlashMessagesManager
 * @package Application\Managers
 */
class FlashMessagesManager
{
    /**
     *
     */
    public function __construct()
    {
        session_start();
    }

    /**
     *
     */
    public function addSuccessMessage()
    {
        $message = new Message();
        $message->setType("success");
        $message->setMessage("Congratulations! You have successfully registered!\n");

        $_SESSION['successMessages'][] = $message;
    }

    /**
     *
     */
    public function addErrorMessage()
    {
        $message = new Message();
        $message->setType("danger");
        $message->setMessage("Unfortunately this email is already in use!\n");

        $_SESSION['errorMessages'][] = $message;
    }

    /**
     * @param $warningText
     */
    public function addWarningMessage($warningText)
    {
        $message = new Message();
        $message->setType("warning");
        $message->setMessage($warningText);

        $_SESSION['warningMessages'][] = $message;
    }
}