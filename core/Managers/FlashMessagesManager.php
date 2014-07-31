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

        $this->session->addToArray(self::SUCCESS, $message);
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

        $this->session->addToArray(self::ERROR, $message);
        return $this;
    }

    public function addWarningMessage($messageText)
    {
        $message = new Message();
        $message->setType(self::WARNING);
        $message->setMessage($messageText);

        $this->session->addToArray(self::WARNING, $message);
        return $this;
    }

    public function addWarningMessages(array $messages = array())
    {
        foreach ($messages as $warningText) {
            $this->addWarningMessage($warningText);
        }
        return $this;
    }

    protected $session;
}