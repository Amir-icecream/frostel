<?php
namespace Core;

use Exception;

class Loader {

    public static function Controller($controller , $values = null){
        $controller_action = explode('@',$controller);
        $controller = $controller_action[0] ?? 'HomeController';
        $action = $controller_action[1] ?? 'show';

        $file = __DIR__ . "/../app/Controller/$controller.php";
        if(!file_exists($file))
        {
            throw new \Exception("Controller : $controller not Found!!");
        }
        require_once($file);
        $controller_class = "App\\Controller\\$controller";
        if(!class_exists($controller_class))
        {
            throw new Exception("controller class: $controller_class not found!!");
        }
        if(!method_exists($controller_class,$action))
        {
            throw new Exception("action : $action in class : $controller_class not found!!");
        }
        $class = new $controller_class();
        return call_user_func_array([$class,$action],array_values($values));
    }

    public static function Error($error,$message){
        $file = __DIR__ . "/../resources/errors/error_page.php";
        return require_once($file);
    }
}