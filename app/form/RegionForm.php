<?php

namespace App\Form;

use Core\Form\Form;
use Core\Validators\NotEmpty;
use Core\Validators\Regex;
use Core\Validators\StringLength;

/**
 * Class RegionForm
 * @package App\Form
 */
class RegionForm extends Form
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
            'region_name',
            array(
                new NotEmpty(array(
                    'message' => "Region name should not be empty!"
                )),
                new StringLength(array(
                    'message' => "Region name should be more the 1 and less then 32 symbols",
                    'min' => self::MIN,
                    'max' => self::MAX
                )),
                new Regex(array(
                    'message' => "Region name is incorrect",
                    'regex' => "/^[A-Za-zА-Яа-я]+$/ui"
                )),
            )
        );
    }
}