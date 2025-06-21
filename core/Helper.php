<?php
use Core\Loader;

function abort($Error){
    $Errors = [
        301 => 'Moved Permanently',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbiden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        408 => 'Request Timeout'
    ];
    if(array_key_exists($Error,$Errors))
    {
        http_response_code($Error);
        return Loader::Error($Error,$Errors[$Error]);
    }
    else
    {
        http_response_code(500);
        throw new Exception("the error code : $Error  is not set in the application!!");
    }
    exit;
}

function view($view , $values = []){
    return Loader::View($view , $values);
}

function redirect($location){
    http_response_code(307);
    header("Location: $location");
    exit;
}
