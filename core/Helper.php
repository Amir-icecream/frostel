<?php
function abort($Error){
    $Errors = [
        404 => 'Not Found',
        403 => 'Forbiden'
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

