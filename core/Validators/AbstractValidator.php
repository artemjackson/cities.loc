<?php

namespace Core\Validators;

/**
 * Class AbstractValidator
 * @package Core\Validators
 */
/**
 * Class AbstractValidator
 * @package Core\Validators
 */
abstract class AbstractValidator implements ValidatorInterface
{
    /**
     * @var
     */
    protected
        $message;
    /**
     * @var array
     */
    protected
        $options = array();

    /**
     * @param array $options
     */
    public function  __construct(array $options = array())
    {
        $this->options = $options;
    }

    /**
     * @param $option
     * @return null
     */
    public function getOption($option)
    {
        if (!empty($this->options[$option])) {
            return $this->options[$option];
        } else {
            return null;
        }
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param $message
     * @return $this
     */
    protected function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
}