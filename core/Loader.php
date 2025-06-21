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
        extract($values);
        require_once($file);
        if(!class_exists($controller))
        {
            throw new Exception("controller class: $controller not found!!");
        }
        if(!method_exists($controller,$action))
        {
            throw new Exception("action : $action in class : $controller not found!!");
        }
        $class = new $controller();
        return $class->$action();
    }

    public static function View($view , $val = null){
        $file = __DIR__ . "/../resources/view/$view.php";
        if(!file_exists($file))
        {
            http_response_code(500);
            throw new \Exception("view : $view not found!!");
        }
        if(is_array($val))
        {
            extract($val);
        }
        return require_once($file);

    }

    public static function Error($error,$message){
        $file = __DIR__ . "/error.php";
        return require_once($file);
    }
}