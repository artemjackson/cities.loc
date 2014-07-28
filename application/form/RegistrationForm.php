<?php

namespace Application\Form;

use Core\Form\Form;
use Core\Validators\Between;
use Core\Validators\NotEmpty;
use Core\Validators\Regex;

/**
 * Class RegistrationForm
 * @package Application\Form
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
                new NotEmpty(),
                new Between(array('min' => 1, 'max' => 32)),
                new Regex(array('regex' => "/^[A-Za-zА-Яа-я]+$/ui")),
            )
        );

        $this->bindValidators(
            'second_name',
            array(
                new NotEmpty(),
                new Between(array('min' => 1, 'max' => 32)),
                new Regex(array('regex' => "/^[A-Za-zА-Яа-я]+$/ui")),
            )
        );

        $this->bindValidators(
            'email',
            array(
                new NotEmpty(),
                new Between(array('min' => 5, 'max' => 64)),
                new Regex(array('regex' => "/^[A-Za-z]+[A-Za-z0-9]*@[A-Za-z]+[A-Za-z0-9]*[.][A-Za-z]+[A-Za-z0-9]*/")),
            )
        );

        $this->bindValidators(
            'password',
            array(
                new NotEmpty(),
                new Between(array('min' => 7, 'max' => 255)),
            )
        );

        $this->bindValidators(
            'password_confirm',
            array(
                new NotEmpty(),
                new Between(array('min' => 7, 'max' => 255)),
            )
        );
    }

    public function isValid()
    {
        if(parent::isValid()){
            if($this->data['password']['value'] === $this->data['password_confirm']['value']){
                return true;
            }
            $this->setMessage("Passwords do not match each other.\n");
        }
        return false;
    }

}