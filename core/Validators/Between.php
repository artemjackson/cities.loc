<?php

namespace Core\Validators;

use Core\Validators\Exceptions\ValidatorException;

/**
 * Class Between
 * @package Core\Validators
 */
//TODO if you use this validator for string length then it is not clear from the name. You need validator something like StringLength with options min and max
class Between extends AbstractValidator
{
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

        $strlen = strlen($value); //TODO it is not PSR use camel style $strLen
        $valid = $strlen > $min && $strlen < $max;

        if ($valid === false) { //TODO false === $valid
            $this->setMessage("Length should be more then {$min} and less then {$max} symbols ");
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