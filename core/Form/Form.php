<?php

namespace Core\Form;

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
     * @var
     */
    protected $message = array();

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
        foreach ($this->data as $field) {
            foreach ($field['validators'] as $validator) {
                if (!$validator->isValid($field['value'])) {
                    $this->addMessage($validator->getMessage());
                    $valid = false;
                    continue 2; // skip other validators of this field if one is not valid
                }
            }
        }
        return $valid;
    }


    /**
     * @param $id
     * @param array $validators
     */
    public function bindValidators($id, array $validators = array())
    {
        $value = !empty($this->data[$id]) ? $this->data[$id] : null;
        $this->data[$id] = array(
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

    /**
     * @param $message
     * @return $this
     */
    protected function setMessage($message)
    {
        $this->message = null;
        $this->message[] = $message;
        return $this;
    }

    protected function addMessage($message)
    {
        $this->message[] = $message;
    }
}