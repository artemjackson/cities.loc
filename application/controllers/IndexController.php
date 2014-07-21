<?php
namespace Application\Controllers;

use Core\AbstractController;
use Application\Views\IndexView;
use Core\View;

class IndexController extends AbstractController
{
    public function indexAction()
    {
        $this->view = new IndexView();
        $this->view->generate('index.phtml');
       // return new View('index/index',array(

       // ));

    }
}