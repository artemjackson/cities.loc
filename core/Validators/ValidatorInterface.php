<?php

namespace Core\Validators;

/**
 * Interface ValidatorInterface
 * @package Core\Validators
 */
interface ValidatorInterface
{
    /**
     * @param $value
     * @return mixed
     */
    public function isValid($value);

    /**
     * @return string
     */
    public function getMessage();
}