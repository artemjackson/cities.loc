<?php

namespace Core\Form;

/**
 * Class Form
 * @package Core\Form
 */
/**
 * Class Form
 * @package Core\Form
 */
class Form
{
    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var array
     */
    protected $bindData = array(); // data with validators on it

    /**
     * @var
     */
    protected $message = array(); // TODO it is array. it should be $messages

    /**
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        $this->setData($data);
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        $valid = true;
        foreach ($this->bindData as $field) {
            foreach ($field['validators'] as $validator) {
                //TODO you must check if $validator instanceof Validator to be sure that it is a validator and has methods isValid and getMessage
                if (!$validator->isValid($field['value'])) {
                    $this->addMessage($validator->getMessage());
                    $valid = false;
                    continue 2; // skip other validators of this field if one is not valid TODO it should be configurable
                }
            }
        }
        return $valid;
    }

    /**
     * @param $message
     */
    protected function addMessage($message)
    {
        $this->message[] = $message;
    }

    /**
     * @param $id
     * @param array $validators
     */
    public function bindValidators($id, array $validators = array())
    {
        $value = !empty($this->data[$id]) ? $this->data[$id] : null;
        $this->bindData[$id] = array(
            'value' => $value,
            'validators' => $validators
        );
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessages()
    {
        return $this->message;
    }
}