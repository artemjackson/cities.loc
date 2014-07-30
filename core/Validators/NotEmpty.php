<?php

namespace Core\Validators;

/**
 * Class NotEmpty
 * @package Core\Validators
 */
class NotEmpty extends AbstractValidator
{
    public function __construct(array $options = array())
    {
        parent::__construct($options);
        $this->setDefaultMessage("The value is empty");
    }

    /**
     * @param $value
     * @return bool
     * @throws Exceptions\ValidatorException
     */
    public function isValid($value)
    {
        $valid = !empty($value);

        if (false === $valid) {
            if (is_null($this->getMessage())) {
                $this->setMessage($this->getDefaultMessage());
            }
        }

        return $valid;
    }
}