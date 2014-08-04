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

        $adminData = $this->session->loggedIn->getData();

        $firstName = !empty($adminData['firstName']) ? $adminData['firstName'] : null;
        $lastName = !empty($adminData['lastName']) ? $adminData['lastName'] : null;

        if ($firstName && $lastName) {
            return $this->exportFrom(
                "admin/dashboard",
                array(
                    'firstName' => $firstName,
                    'lastName' => $lastName
                )
            );
        }
    }

    protected $menu = array(
        'Users' => '/admin/users/',
        'Regions' => '/admin/regions/',
        'Cities' => '/admin/cities/',
        'Back to site' => '/home/',
        'Logout' => '/user/logout',
    );

    public function menu()
    {
        $currentPage = $this->currentPage();

        $html = "<ul class=\"nav nav-pills pull-right\">";

        foreach ($this->menu as $page => $link) {
            $html .= "<li ";
            if ($currentPage === $page) {
                $html .= "class=\"active\"";
            }
            $html .= "><a href=\"" . $link . "\">$page</a></li>";
        }

        $html .= "</ul>";
        return $html;
    }
}
