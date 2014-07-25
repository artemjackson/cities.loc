<?php

namespace Application\Models\Database\Exceptions;

/**
 * Class DatabaseException
 * @package Application\Models\Database\Exceptions
 */
class DatabaseException extends \Exception
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
            $this->message .= $this->getPrevious() . ' : ' . $this->getPrevious()->getMessage();
        }
    }
}