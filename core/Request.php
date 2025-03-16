<?php
namespace Core;

class Request{
    public static function Url(){
        return($_SERVER['REQUEST_URI']);
    }
    public static function Method(){
        return($_SERVER['REQUEST_METHOD']);
    }
}