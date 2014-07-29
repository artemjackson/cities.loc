<?php

namespace Core\MVC\Router\Exceptions;

/**
 * Class ControllerException
 * @package Core\MVC\Router\Exceptions
 */
class ControllerException extends \Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        if (!is_null($previous)) {
            $this->message .= $this->getPrevious() . ' : ' . $this->getPrevious()->getMessage(); //TODO why?
        }
    }

}