<?php
namespace Core;
class Session {
    public static function Start(){
        if(session_status() == PHP_SESSION_NONE)
        {
            return session_start();
        }
    }
    public static function Destroy(){
        if(session_status() == PHP_SESSION_ACTIVE)
        {
            return session_destroy();
        }
    }
    public static function Is_Active(){
        if(session_status() == PHP_SESSION_ACTIVE)
        {
            return true;
        }
        return false;
    }
    public static function Unset($session_key){
        if(self::Is_Active())
        {
            if(isset($_SESSION[$session_key]))
            {
                unset($_SESSION[$session_key]);
            }
        }
    }
    public static function Set($key,$value){
        if(self::Is_Active())
        {
            return $_SESSION[$key] = $value;
        }
    }
    public static function Get($session_key){
        if(isset($_SESSION[$session_key]))
        {
            return($_SESSION[$session_key]);
        }
    }
    public static function Has($session_key){
        if(isset($_SESSION[$session_key]))
        {
            return true;
        }
        return false;
    }
}