<?php

namespace Core\Validators;

/**
 * Class ExactlyEqual
 * @package Core\Validators
 */
class ExactlyEqual extends AbstractValidator
{
    /**
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        parent::__construct($options);
        $this->setDefaultMessage("The values are different");
    }

    /**
     * @param $value
     * @return bool
     * @throws Exceptions\ValidatorException
     */
    public function isValid($value)
    {
        $valid = $this->getOption('pattern') === $value;

        if (false === $valid) {
            if (is_null($this->getMessage())) {
                $this->setMessage($this->getDefaultMessage());
            }
        }

        return $valid;
    }
}