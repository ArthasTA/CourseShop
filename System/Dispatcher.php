<?php

namespace System;

/**
 * Class Dispatcher
 * @package System
 */
class Dispatcher
{

    /**
     * Main dispatcher control class
     * @return void
     */
    public function dispatch()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        $rule = Config::get($url);
        $controller = $rule['controller'];
        $action = $rule['action'];

        if (class_exists($controller) && method_exists($controller, $action)) {
            $controller = new $controller();
            $controller->$action();
        } else {
            ob_start();
            include_once APP_ROOT . '/MVC/View/errors/404.phtml';
            $content = ob_get_clean();
            include APP_ROOT . 'MVC/Layout/main.phtml';
        }
    }
}