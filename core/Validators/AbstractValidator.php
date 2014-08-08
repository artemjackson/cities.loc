<?php

namespace Core\Validators;

/**
 * Class AbstractValidator
 * @package Core\Validators
 */
abstract class AbstractValidator implements ValidatorInterface
{
    /**
     * @var
     */
    protected $defaultMessage;
    /**
     * @var
     */
    protected $message;
    /**
     * @var array
     */
    protected $options = array();

    /**
     * @param array $options
     */
    public function  __construct(array $options = array())
    {
        $this->options = $options;
        if (!is_null($this->getOption('message'))) {
            $this->setMessage($this->getOption('message'));
        }
    }

    /**
     * @param $option
     * @return null
     */
    public function getOption($option)
    {
        return !empty($this->options[$option]) ? $this->options[$option] : null;
    }

    /**
     * @return mixed
     */
    public function getDefaultMessage()
    {
        return $this->defaultMessage;
    }

    /**
     * @param mixed $defaultMessage
     */
    public function setDefaultMessage($defaultMessage)
    {
        $this->defaultMessage = $defaultMessage;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    //TODO what about to check if message is empty than use default message. So you don't need to check it in all validators

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
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
}