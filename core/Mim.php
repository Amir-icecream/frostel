<?php
namespace Core;

use Exception;
use Config\MimTypes;

class Mim{
    private static $mimTypes;

    private static function init(){
        self::$mimTypes = MimTypes::get();
    }
    public static function getFileMim(string $filepath){
        self::init();
        if(file_exists($filepath) && is_readable($filepath))
        {
            $extension = strtolower(pathinfo($filepath,PATHINFO_EXTENSION));
            if(array_key_exists($extension,self::$mimTypes))
            {
                return self::$mimTypes[$extension];
            }
            throw new Exception("extension not exist in mimtypes list");
        }
        throw new Exception("there is no file to get extension from or it is not readable");
    }

    public static function getAllMim():array{
        return self::$mimTypes;
    }
}