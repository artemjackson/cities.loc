<?php

namespace App\Form;

use Core\Form\Form;
use Core\Validators\NotEmpty;
use Core\Validators\Regex;
use Core\Validators\StringLength;


/**
 * Class CityForm
 * @package App\Form
 */
class CityForm extends Form
{
    /**
     *
     */
    const MIN = 1;
    /**
     *
     */
    const MAX = 32;
    /**
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        parent::__construct($data);

        $this->bindValidators(
            'city_name',
            array(
                new NotEmpty(array(
                    'message' => "City name should not be empty!"
                )),
                new StringLength(array(
                    'message' => "City name should be more the 1 and less then 32 symbols",
                    'min' => self::MIN,
                    'max' => self::MAX
                )),
                new Regex(array(
                    'message' => "City name is incorrect",
                    'regex' => "/^[A-Za-zА-Яа-я]+$/ui"
                )),
            )
        );
    }
}