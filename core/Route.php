<?php
namespace Core;

use Core\Request;

class Route extends Middleware{
    private $Routes = [];  
    private $lastRoute = [];
    private $middlewares = [];

    public function __construct() {
        $this->Routes = [
            "get" => [],
            "post" => [],
            "patch" => [],
            "delete" => [],
            "put" => []
        ];
    }

    public function get($url , $controller){
        $this->Routes['get'][$url] = $controller;
        $this->lastRoute = ['method' => 'get' , 'route' => $url];
        return $this;
    }
    public function post($url , $controller){
        $this->Routes['post'][$url] = $controller;
        $this->lastRoute = ['method' => 'post' , 'route' => $url];
        return $this;
    }
    public function patch($url , $controller){
        $this->Routes['patch'][$url] = $controller;
        $this->lastRoute = ['method' => 'patch' , 'route' => $url];
        return $this;
    }
    public function delete($url , $controller){
        $this->Routes['delete'][$url] = $controller;
        $this->lastRoute = ['method' => 'delete' , 'route' => $url];
        return $this;
    }
    public function put($url , $controller){
        $this->Routes['put'][$url] = $controller;
        $this->lastRoute = ['method' => 'put' , 'route' => $url]; 
        return $this;
    }

    public function middleware($middleware){
        $method = $this->lastRoute['method'];
        $route = $this->lastRoute['route'];
        $this->middlewares[$method][$route] = $middleware;
        
        return $this;
    }

    public function Dispatch($url,$method){
        $values = [];
        $method = strtolower($method);
        $Routes = $this->Routes[$method];
        foreach ($Routes as $route => $controller) {
            $pattern = '/({\w+})/';
            $a = preg_replace($pattern,'(\w+)',$route);
            $a = str_replace('/','\/',$a);
            $a = '/' . $a . '/';
            preg_match($a,$url,$matches);
            if(count($matches) !== 0)
            {
                array_shift($matches);
                preg_match_all('/{(\w+)}/',$route,$mat);
                print_r($mat);
                foreach ($matches as $key => $value) {
                    $values += [$key => $value];
                }
                // print_r($a);
                // return print_r($matches);
                preg_match_all('/{(\w+)}/',$route,$mat);
                return 1;
            }
        }
        return(\abort(404));
    }

}