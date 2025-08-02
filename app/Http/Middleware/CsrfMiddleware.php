<?php
namespace App\Http\Middleware;

use Core\Csrf;
use Core\Request;

class CsrfMiddleware {
    private static $except = [
        '/resource/css/*',
        '/resource/js/*',
        '/storage/img/*',
    ];
    public function handle()
    {
        $method = strtoupper(Request::method()) ?? '';
        $url = Request::url() ?? '';
        foreach (self::$except as $key => $value) {
            $pattern = str_replace('\*','.*',preg_quote($value,'#'));
            if(preg_match("#^{$pattern}$#",$url)){
                return true;
            }
        }

        if($method === 'GET' || $method === 'HEAD' || $method === 'OPTIONS'){
            return true;
        }
        return Csrf::validate();
    }
}