<?php
namespace Core;

use Exception;

class Middleware{
    public static function handel(string $middleware){
        $middlewarePath = realpath(__DIR__ . "/../app/Middleware/{$middleware}.php");
        if(file_exists($middlewarePath))
        {
            require_once($middlewarePath);
            $middlewareClassPath = "App\\Middleware\\{$middleware}";
            if(class_exists($middlewareClassPath)){
                $middlewareClass = new $middlewareClassPath;
                if(method_exists($middlewareClass,'run'))
                {
                    return call_user_func([$middlewareClass,'run']);
                }else{
                    throw new Exception("function : run not found in middleware: {$middleware}");
                }
            }else{
                throw new Exception("middleware : {$middleware} not found");
            }
        }else{
            throw new Exception("middleware : {$middleware} not found");
        }
    }
}