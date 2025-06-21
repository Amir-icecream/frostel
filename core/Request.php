<?php
namespace Core;

class Request{

    public static function Url(){
        return($_SERVER['REQUEST_URI']);
    }
    public static function Method(){
        return($_SERVER['REQUEST_METHOD']);
    }
    public static function Agent(){
        return($_SERVER['HTTP_USER_AGENT']);
    }
    public static function Platform(){
        return($_SERVER['HTTP_SEC_CH_UA_PLATFORM']);
    }
    public static function File(){
        return $_FILES;
    }
    
    public static function Data(){
        if(strtolower(self::Url()) === 'get')
        {
            return $_GET;
        }
        else
        {
            return $_POST;
        }    
    }
    
}