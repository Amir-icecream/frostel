<?php
namespace App\Http;

use Core\Middleware;

class Kernel{
    protected static $globalMiddleware = [
        'SessionMiddleware@handle',
        'CsrfMiddleware@handle',
    ];
    public static function handle(){
        // run global middlewares
        foreach (self::$globalMiddleware as $key => $value) {
            Middleware::handel($value);
        }
    }
}