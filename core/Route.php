<?php
namespace Core;

use Request;
use Exception;
use Core\Loader;

class Route extends Middleware{
    private static $Routes = [];  
    private static $lastRoute = [];
    private static $middlewares = [];

    public function __construct() {
        self::$Routes = [
            "get" => [],
            "post" => [],
            "patch" => [],
            "delete" => [],
            "put" => []
        ];
    }

    public static function get($url , $controller){
        self::$Routes['get'][$url] = $controller;
        self::$lastRoute = ['method' => 'get' , 'route' => $url];
        return self::class;
    }
    public static function post($url , $controller){
        self::$Routes['post'][$url] = $controller;
        self::$lastRoute = ['method' => 'post' , 'route' => $url];
        return self::class;
    }
    public static function patch($url , $controller){
        self::$Routes['patch'][$url] = $controller;
        self::$lastRoute = ['method' => 'patch' , 'route' => $url];
        return self::class;
    }
    public static function delete($url , $controller){
        self::$Routes['delete'][$url] = $controller;
        self::$lastRoute = ['method' => 'delete' , 'route' => $url];
        return self::class;
    }
    public static function put($url , $controller){
        self::$Routes['put'][$url] = $controller;
        self::$lastRoute = ['method' => 'put' , 'route' => $url]; 
        return self::class;
    }

    public static function middleware($middleware){
        $method = self::$lastRoute['method'];
        $route = self::$lastRoute['route'];
        if(!isset(self::$middlewares[$method][$route]))
        {
            self::$middlewares[$method][$route] = [];
        }
        if(is_array($middleware))
        {
            self::$middlewares[$method][$route] = array_merge(self::$middlewares[$method][$route] , $middleware);
        }
        else
        {
            self::$middlewares[$method][$route][] = $middleware;
        }
        
        return self::class;
    }
    
    public static function Dispatch($url,$method){
        $values = array();

        $method = strtolower($method);
        $Routes = self::$Routes[$method];

        foreach ($Routes as $route => $controller) {
            $pattern = preg_replace('/{(\w+)}/',"([^/]+)",$route);

            preg_match('#^' . $pattern . '$#',$url , $matches);
            if(count($matches))
            {
                if(count(self::$middlewares) and !empty(self::$middlewares[$method]))
                {
                    if(array_key_exists($route , self::$middlewares[$method]))
                    {
                        foreach (self::$middlewares[$method][$url] as $key => $value) {
                            if(!Middleware::handel($value))
                            {
                                return abort(406);
                            }
                        }
                    }
                }

                preg_match('#^' . $pattern . '$#',$route,$m);
                array_shift($matches);
                array_shift($m);
                foreach ($m as $key => $value) {
                    $values[trim($value,'{}')] = $matches[$key];
                }
                return Loader::Controller($controller,$values);
            }
        }
        abort(404);
    }

}

//working on middleware 🔴