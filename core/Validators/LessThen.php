<?php

namespace Core\Validators;

use Core\Validators\Exceptions\ValidatorException;

/**
 * Class LessThen
 * @package Core\Validators
 */
class LessThen extends AbstractValidator
{
    /**
     * @param $value
     * @return bool
     * @throws Exceptions\ValidatorException
     */
    public function isValid($value)
    {
        $max = $this->getMax();

        if (is_null($max)) {
            throw new ValidatorException("No max value was specified in LessThen validator.\n");
        }

        $strlen = strlen($value); //TODO strLen
        $valid = $strlen < $max;

        if ($valid === false) { //TODO false === $valid
            $this->setMessage("Length should be less then {$max} symbols ");
        }

        return $valid;
    }

    /**
     * @return mixed
     */
    public function getMax()
    {
        return $this->getOption('max');
    }
}