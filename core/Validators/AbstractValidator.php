<?php

namespace Core\Validators;

    /**
     * Class AbstractValidator
     * @package Core\Validators
     */
abstract class AbstractValidator implements ValidatorInterface
{
    protected $defaultMessage;

    /**
     * @param mixed $defaultMessage
     */
    public function setDefaultMessage($defaultMessage)
    {
        $this->defaultMessage = $defaultMessage;
    }

    /**
     * @return mixed
     */
    public function getDefaultMessage()
    {
        return $this->defaultMessage;
    }

    /**
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

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
        if(!is_null($this->getOption('message'))){
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