<?php

namespace Core\MVC\View\Helpers;

use Core\App;
use Core\Session\Session;

class Menu extends AbstractHelper
{
    protected $menu = array(
        'Home' => '/home/',
        'Map' => '/map/',
        'About' => '/about/',
        'Registration' => '/registration/',
        'Login' => '/user/login',
        'Logout' => '/user/logout/'
    );

    public function help()
    {
        include App::getConfig('view', 'templatesPath') . "menu.phtml";
    }

    public function menu()
    {
        $currentPage = $this->currentPage();
        $session = new Session();
        $loggedIn = isset($session->loggedIn);
        $menu = $this->menu;
        if ($loggedIn) {
            unset($menu['Login']);
        } else {
            unset($menu['Logout']);
        }

        $html = "<ul class=\"nav nav-pills pull-right\">";

        foreach ($menu as $page => $link) {
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