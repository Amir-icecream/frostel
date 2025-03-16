<?php
namespace Core;

use Core\Request;

class Route{
    private $Routes; 

    public function __construct() {
        $this->Routes = [
            "GET" => [],
            "POST" => [],
            "PATCH" => [],
            "DELETE" => [],
            "PUT" => []
        ];
    }

    public function GET($url , $controller){
        $this->Routes['GET'][$url] = $controller;
    }
    public function POST($url , $controller){
        $this->Routes['POST'][$url] = $controller;
    }
    public function PATCH($url , $controller){
        $this->Routes['PATCH'][$url] = $controller;
    }
    public function DELETE($url , $controller){
        $this->Routes['DELETE'][$url] = $controller;
    }
    public function PUT($url , $controller){
        $this->Routes['PUT'][$url] = $controller;
    }

    public function Dispatch($url,$method){
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