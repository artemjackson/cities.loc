<?php

namespace Core\Validators;

/**
 * Class NotEmpty
 * @package Core\Validators
 */
class NotEmpty extends AbstractValidator
{
    /**
     * @param $value
     * @return bool
     * @throws Exceptions\ValidatorException
     */
    public function isValid($value)
    {
        $valid = !empty($value);

        if ($valid === false) {
            $this->setMessage("The value should not be empty ");
        }

        return $valid;
    }
}