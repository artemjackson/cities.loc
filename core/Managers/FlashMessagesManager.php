<?php

namespace Core\Managers;

use Core\Message\Message;
use Core\Session\Session;

/**
 * Class FlashMessagesManager
 * @package Application\Managers
 */
class FlashMessagesManager
{
    const SUCCESS = 'success';
    const WARNING = 'warning';
    const ERROR = 'danger';

    /**
     *
     */
    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     *
     */
    public function addSuccessMessage($messageText)
    {
        $message = new Message();
        $message->setType(self::SUCCESS);
        $message->setMessage($messageText);

        $messages = isset($this->session->successMessages) ? $this->session->succesMessages : array();
        array_push($messages, $message);

        $this->session->successMessages = $messages;
        return $this;
    }

    /**
     *
     */
    public function addErrorMessage($messageText)
    {
        $message = new Message();
        $message->setType(self::ERROR);
        $message->setMessage($messageText);

        $messages = isset($this->session->errorMessages) ? $this->session->errorMessages : array();
        array_push($messages, $message);

        $this->session->errorMessages = $messages;
        return $this;
    }

    public function addWarningMessage($messageText)
    {
        $message = new Message();
        $message->setType(self::WARNING);
        $message->setMessage($messageText);

        $messages = isset($this->session->warningMessages) ? $this->session->warningMessages : array();
        array_push($messages, $message);

        $this->session->warningMessages = $messages;
        return $this;
    }

    public function addWarningMessages(array $messages = array())
    {
        foreach ($messages as $warningText) {
            $this->addWarningMessage($warningText);
        }
        return $this;
    }

    protected $session; //TODO is it PSR position of a property?
}