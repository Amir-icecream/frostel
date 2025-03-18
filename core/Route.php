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
        $method = strtolower($method);
        $request_middleware = $this->middlewares[$method][$url];
        print_r($request_middleware);
        exit;
        foreach ($this->Routes[$method] as $route => $controller) {
            $pattern = preg_replace('/\/(\d+)/', '/{id}', $url);
            if($pattern === $route)
            {
                print_r($pattern);
                return(0);
            }

        }

        return(\abort(404));
    }

}