<?php
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
        $error = $Error;
        $message = $Errors[$Error];
        require_once(__DIR__ . "/error.php");
    }
    else
    {
        http_response_code(500);
        throw new Exception("the error code : $Error  is not set in the application!!");
    }
    exit;
}

function view($view , $values = []){
    if(file_exists(__DIR__ . "/../resources/view/$view.php"))
    {
        extract($values);
        require_once(__DIR__ . "/../resources/view/$view.php");
    }
    else
    {
        http_response_code(500);
        throw new Exception("view $view not found!!");
        exit;
    }
}

