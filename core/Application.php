<?php
namespace Core;

use Application\Views\View;
use Core\Route;

class Application
{
    public function __construct($configuration)
    {
        $this->router = new Router($configuration);
    }

    public function run()
    {
        try {
            $this->router->run();
        } catch (Exceptions\NoSuchControllerException $e) {
            $this->error404();
            exit;
        }

        $controller = $this->router->getController();
        $controllerAction = $this->router->getControllerAction();

        $view = $controller->$controllerAction();

        if (!$view->getTemplate()) {
            $template = $this->getTemplateByContoller($controller, $controllerAction);
            $view->setTemplate($template);
        }
        $view->render();
    }

    protected function error404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . 'notfound');
    }

    protected function getTemplateByContoller($controller, $controllerAction)
    {
        $controllerName = get_class($controller);

        $controllerName = substr($controllerName, strripos($controllerName, "\\") + 1);
        $controllerName = substr($controllerName, 0, strripos($controllerName, "Controller"));

        $actionName = substr($controllerAction, 0, strripos($controllerAction, "Action"));

        $template = $controllerName . DIRECTORY_SEPARATOR . $actionName;
        $template = strtolower($template);

        return $template;
    }

    protected $router;
}