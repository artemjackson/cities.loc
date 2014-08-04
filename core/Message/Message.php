<?php
//TODO where do you use this class? Only with flash messages?  - Yes
namespace Core\Message;

/**
 * Class Message
 * @package Core\Message
 */
class Message
{
    /**
     * @var
     */
    protected $message;
    /**
     * @var
     */
    protected $type;

    /**
     * @param null $type
     * @param null $message
     */
    public function __construct($type = null, $message = null)
    {
        $this->setType($type);
        $this->setMessage($message);
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return array
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
}