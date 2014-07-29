<?php

namespace Core\Validators\Exceptions;

/**
 * Class ValidatorException
 * @package Core\Validator\Exceptions
 */
class ValidatorException extends \Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous); //TODO why do we need this constructor?
    }
}