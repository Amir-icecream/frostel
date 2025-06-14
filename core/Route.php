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
        $values = array();

        $method = strtolower($method);
        $Routes = $this->Routes[$method];

        foreach ($Routes as $route => $controller) {
            $pattern = preg_replace('/{(\w+)}/',"([^/]+)",$route);

            preg_match('#^' . $pattern . '$#',$url , $matches);
            if(count($matches) && true)
            {
                preg_match('#^' . $pattern . '$#',$route,$m);
                array_shift($matches);
                array_shift($m);
                foreach ($m as $key => $value) {
                    $values[trim($value,'{}')] = $matches[$key];
                }
                extract($values);
                return require_once(__DIR__ . "/../app/Controller/$controller.php");
            }
        }
        abort(404);
    }

}

//working on middleware 🔴
