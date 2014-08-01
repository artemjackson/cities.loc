<?php

namespace App\Form;

use Core\Form\Form;
use Core\Validators\ExactlyEqual;
use Core\Validators\NotEmpty;
use Core\Validators\Regex;
use Core\Validators\StringLength;

/**
 * Class RegistrationForm
 * @package App\Form
 */
class RegistrationForm extends Form
{
    /**
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        parent::__construct($data);

        $this->bindValidators(
            'first_name',
            array(
                new NotEmpty(array(
                    'message' => "First name should not be empty!"
                )),
                new StringLength(array(
                    'message' => "First name should be more the 1 and less then 32 symbols",
                    'min' => 1,
                    'max' => 32
                )),
                new Regex(array(
                    'message' => "First name is incorrect",
                    'regex' => "/^[A-Za-zА-Яа-я]+$/ui"
                )),
            )
        );

        $this->bindValidators(
            'last_name',
            array(
                new NotEmpty(array(
                    'message' => "Last name should not be empty!"
                )),
                new StringLength(array(
                    'message' => "Last name should be more the 1 and less then 32 symbols",
                    'min' => 1,
                    'max' => 32
                )),
                new Regex(array(
                    'message' => "Last name is incorrect",
                    'regex' => "/^[A-Za-zА-Яа-я]+$/ui"
                )),
            )
        );

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
                    'min' => 5,
                    'max' => 64
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
                    'min' => 7,
                    'max' => 255
                )),
            )
        );

        $this->bindValidators(
            'password_confirm',
            array(
                new NotEmpty(
                    array(
                        'message' => "Password confirm should not be empty!"
                    )
                ),
                new ExactlyEqual(array(
                    'pattern' => $this->data['password'],
                    'message' => "Password and Password confirm do not match each other"
                ))
            )
        );
    }
}