<?php

namespace Core\MVC\View\Helpers;

class AdminDashboard extends AbstractHelper
{
    public function help()
    {
        if (!isset($this->session->loggedIn)) {
            return "";
        }

        if (!$this->session->loggedIn->hasRole('admin')) {
            return "";
        }

        return $this->exportFrom("admin/dashboard");
    }
}
