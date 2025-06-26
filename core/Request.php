<?php
namespace Core;

class Request{
    public static function url(): string{
        return($_SERVER['REQUEST_URI'] ?? '/');
    }
    public static function method(): string{
        return($_SERVER['REQUEST_METHOD'] ?? 'GET');
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