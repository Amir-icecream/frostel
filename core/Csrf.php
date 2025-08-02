<?php
namespace Core;

class Csrf{
    public static function validate(bool $keep = true){
        $session_token = $_SESSION['X-CSRF-TOKEN'] ?? '';
        $header_token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        $input_token = Request::data()['X_CSRF_TOKEN'] ?? '';
        if(empty($header_token) && empty($input_token)){
            abort(419);
        }
        if(!empty($session_token) && !empty($header_token) && hash_equals($session_token,$header_token)){
            if($keep === false){
                unset($_SESSION['X-CSRF-TOKEN']);
            }
            return true;
        }elseif(!empty($session_token) && !empty($input_token) && hash_equals($session_token,$input_token)){
            if($keep === false){
                unset($_SESSION['X-CSRF-TOKEN']);
            }
            return true;
        }
        else{
            abort(419);
        }
    }
    public static function generateToken(){
        if(empty($_SESSION['X-CSRF-TOKEN']))
        {
            $csrf_token = bin2hex(random_bytes(16));
            $_SESSION['X-CSRF-TOKEN'] = $csrf_token;
        }
        return;
    }
    public static function getToken(){
        if(empty($_SESSION['X-CSRF-TOKEN'])){
            self::generateToken();
        }
        return $_SESSION['X-CSRF-TOKEN'] ?? '';
    }
}