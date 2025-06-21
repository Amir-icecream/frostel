<?php
namespace Core;

class Bootstrap{

    public static function ApiCheck($url){
        return preg_match('#^/api(/|$)#',$url,$matches) === 1;
    }
}