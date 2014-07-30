<?php

namespace Core\Validators;

use Core\Validators\Exceptions\ValidatorException;

/**
 * Class Between
 * @package Core\Validators
 */
class StringLength extends AbstractValidator
{
    public function __construct(array $options = array())
    {
        parent::__construct($options);
        $max = $this->getMax();
        $min = $this->getMin();
        $this->setDefaultMessage("Length should be more then {$min} and less then {$max} symbols ");
    }

    /**
     * @param $value
     * @return bool
     * @throws Exceptions\ValidatorException
     */
    public function isValid($value)
    {
        $max = $this->getMax();
        $min = $this->getMin();

        if (is_null($min)) {
            throw new ValidatorException("No min value was specified in Between validator.\n");
        }

        if (is_null($max)) {
            throw new ValidatorException("No max value was specified in Between validator.\n");
        }

        $strLen = strlen($value);
        $valid = $strLen > $min && $strLen < $max;

        if (false === $valid) {
            if (is_null($this->getMessage())) {
                $this->setMessage($this->getDefaultMessage());
            }
        }

        return $valid;
    }

    /**
     * @return null
     */
    public function getMax()
    {
        return $this->getOption('max');
    }

    /**
     * @return null
     */
    public function getMin()
    {
        return $this->getOption('min');
    }
}