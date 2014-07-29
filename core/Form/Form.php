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
                    $message = $validator->getMessage();
                    $message .= "in " . $field['name'] . " field";
                    $this->addMessage($message);
                    $valid = false;
                    continue 2;      // skip other validators of this field if one is not valid
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
            $value = $this->data[$id];
            $name = str_replace('_',' ', ucfirst($id));
            $this->data[$id] = array(
                'name' => $name,
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
    public function getMessage()
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

    protected function addMessage($message){
        $this->message[] = $message;
    }
}