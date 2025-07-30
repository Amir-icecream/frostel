<?php
namespace Core;

class Request{
    public static function isApiRequest(){
        return preg_match('#^/api/#',self::url());
    }
    public static function isResourceRequest(){
        return preg_match('#^/resource/#',self::url(),$matches);
    }
    public static function isStorageRequest(){
        return preg_match('#^/storage#',self::url(),$matches);
    }

    public static function url(): string{
        $url = $_SERVER['REQUEST_URI'] ?? '/';
        $url = parse_url($url,PHP_URL_PATH);
        $url = urldecode($url);
        return($url);
    }
    public static function method(): string{
        return($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }
    public static function referer(): string{
        return($_SERVER['HTTP_REFERER'] ?? '');
    }
    public static function agent(): string{
        return($_SERVER['HTTP_USER_AGENT'] ?? 'unknown');
    }
    public static function platform(): string{
        return($_SERVER['HTTP_SEC_CH_UA_PLATFORM'] ?? 'unknown');
    }
    public static function file(): array{
        return $_FILES ?? [];
    }
    public static function data(): array{
        return strtolower(self::Method()) === 'get' ? $_GET : $_POST;
    }
    
}