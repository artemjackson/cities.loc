<?php

namespace Core\Validators;

/**
 * Class AbstractValidator
 * @package Core\Validators
 */
//TODO you need to have an option to set validation message
abstract class AbstractValidator implements ValidatorInterface
{
    /**
     * @var
     */
    protected
        $message; //TODO wtf???
    /**
     * @var array
     */
    protected //TODO wtf???
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
        //TODO use ternary operator
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