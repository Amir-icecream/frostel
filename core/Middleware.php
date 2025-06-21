<?php
namespace Core;

use Exception;

class Middleware{
    public static function handel($middleware){
        if(file_exists(__DIR__ . "/../app/Middleware/$middleware.php"))
        {
            return require_once(__DIR__ . "/../app/Middleware/$middleware.php");
        }
        else
        {
            throw new Exception("middleware : $middleware not found");
            return(false);
        }
    }
}