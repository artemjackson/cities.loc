<?php

namespace Core\MVC\View\Helpers;

class FlashMessages extends AbstractHelper
{
    public function help()
    {
        $messagesType = $this->data[0];
        $html = "";
        if (isset($this->session->$messagesType)) {
            foreach ($this->session->$messagesType as $infoMessage) {
                $html .= $this->exportFrom(
                    "registration/message",
                    array(
                        'type' => $infoMessage->getType(),
                        'message' => $infoMessage->getMessage()
                    )
                );
            }
            unset($this->session->$messagesType);
        }
        return $html;
    }
}
