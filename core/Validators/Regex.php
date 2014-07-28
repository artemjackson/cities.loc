<?php

namespace Core\Validators;

/**
 * Class Regex
 * @package Core\Validators
 */
class Regex extends AbstractValidator
{
    /**
     * @param $value
     * @return bool
     * @throws Exceptions\ValidatorException
     */
    public function isValid($value)
    {
        $regex = $this->getRegex();
        $valid = preg_match($regex, $value);

        if ($valid === false) {
            $this->setMessage("Invalid value ");
        }

        return $valid;
    }

    /**
     * @return null
     */
    public function getRegex()
    {
        return $this->getOption('regex');
    }
}