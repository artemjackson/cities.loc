<?php

namespace App\Form;

use Core\Form\Form;
use Core\Validators\NotEmpty;
use Core\Validators\Regex;
use Core\Validators\StringLength;

/**
 * Class RegistrationForm
 * @package App\Form
 */
class SingInForm extends Form
{
    /**
     *
     */
    const PASS_MIN = 7;
    /**
     *
     */
    const PASS_MAX = 255;

    /**
     *
     */
    const EMAIL_MIN = 5;
    /**
     *
     */
    const EMAIL_MAX = 64;

    /**
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        parent::__construct($data);

        $this->bindValidators(
            'email',
            array(
                new NotEmpty(
                    array(
                        'message' => "Email should not be empty!"
                    )
                ),
                new StringLength(array(
                    'message' => "Email should be more the 5 and less then 64 symbols",
                    //TODO see todo for Registration form
                    'min' => self::EMAIL_MIN,
                    'max' => self::EMAIL_MAX
                )),
                new Regex(array(
                    'message' => "Email is incorrect",
                    'regex' => "/^[A-Za-z]+[A-Za-z0-9_]*@[A-Za-z]+[A-Za-z0-9]*[.][A-Za-z]+[A-Za-z0-9]*/"
                )),
            )
        );

        $this->bindValidators(
            'password',
            array(
                new NotEmpty(
                    array(
                        'message' => "Password should not be empty!"
                    )
                ),
                new StringLength(array(
                    'message' => "Password should be more the 7 and less then 255 symbols",
                    'min' => self::PASS_MIN,
                    'max' => self::PASS_MAX
                )),
            )
        );
    }
}