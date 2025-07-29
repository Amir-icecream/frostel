<?php
namespace Core;
class Session {
    public static function start(){
        if(session_status() == PHP_SESSION_NONE)
        {
            return session_start();
        }
    }
    public static function destroy(){
        if(session_status() == PHP_SESSION_ACTIVE)
        {
            return session_destroy();
        }
    }
    public static function is_active(){
        if(session_status() == PHP_SESSION_ACTIVE)
        {
            return true;
        }
        return false;
    }
    public static function unset($session_key){
        if(self::Is_Active())
        {
            if(isset($_SESSION[$session_key]))
            {
                unset($_SESSION[$session_key]);
            }
        }
    }
    public static function set($key,$value){
        if(self::Is_Active())
        {
            return $_SESSION[$key] = $value;
        }
    }
    public static function get($session_key){
        if(isset($_SESSION[$session_key]))
        {
            return($_SESSION[$session_key]);
        }
    }
    public static function has($session_key){
        if(isset($_SESSION[$session_key]))
        {
            return true;
        }
        return false;
    }
}