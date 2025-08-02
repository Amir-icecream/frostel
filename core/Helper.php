<?php
use Core\Loader;
use Core\View;
use Core\Csrf;

function abort($Error){
    $Errors = [
        301 => 'Moved Permanently',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        408 => 'Request Timeout',
        419 => 'Page Expired',
        500 => 'Internal Server Error',
    ];
    if(array_key_exists($Error,$Errors))
    {
        http_response_code($Error);
        Loader::Error($Error,$Errors[$Error]);
        exit;
    }
    else
    {
        http_response_code(500);
        throw new Exception("the error code : $Error  is not set in the application!!");
    }
}

function respons(string $message = 'ok',int $code = 200){
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode(['message' => $message, 'code' => $code]);
    exit;
}

function view($view , $values = []){
    $view_loader = new View;
    return $view_loader->render($view,$values);
}

function redirect($location){
    http_response_code(307);
    header("Location: $location");
    exit;
}

function csrf_token(){
    return Csrf::getToken();
}