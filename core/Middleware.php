<?php
namespace Core;

use Exception;

class Middleware{
    public static function handel(string $middleware){
        $midd_action = explode('@',$middleware);
        $middleware = $midd_action[0] ?? '';
        $action = $midd_action[1] ?? '';

        $middlewarePath = realpath(__DIR__ . "/../app/Http/Middleware/{$middleware}.php");
        if(file_exists($middlewarePath))
        {
            require_once($middlewarePath);
            $middlewareClassPath = "App\\Http\\Middleware\\{$middleware}";
            if(class_exists($middlewareClassPath)){
                $middlewareClass = new $middlewareClassPath;
                if(method_exists($middlewareClass,$action))
                {
                    return call_user_func([$middlewareClass,$action]);
                }else{
                    throw new Exception("function : {$action} not found in middleware: {$middleware}");
                }
            }else{
                throw new Exception("middleware : {$middleware} not found");
            }
        }else{
            throw new Exception("middleware : {$middleware} not found");
        }
    }
}