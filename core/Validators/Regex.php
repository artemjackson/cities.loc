<?php

namespace Core\Validators;

/**
 * Class Regex
 * @package Core\Validators
 */
class Regex extends AbstractValidator
{
    /**
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        parent::__construct($options);
        $this->setDefaultMessage("Value does not match regular expression.");
    }

    /**
     * @param $value
     * @return bool
     * @throws Exceptions\ValidatorException
     */
    public function isValid($value)
    {
        $regex = $this->getRegex();
        $valid = preg_match($regex, $value);

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
    public function getRegex()
    {
        return $this->getOption('regex');
    }
}