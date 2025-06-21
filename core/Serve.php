<?php
namespace Core;

class Serve{

    public static function img(string $name){
        $name = basename($name);
        $baseDir = realpath(__DIR__ . "/../storage/img/");
        $filepath = realpath($baseDir . DIRECTORY_SEPARATOR . $name);
        if(!$filepath || strpos($filepath, $baseDir) !== 0)
        {
            http_response_code(403);
            exit("access denied!!");
        }
        $mim = mime_content_type($filepath);
        header("Content-Type: $mim");
        header("Content-Length: " . filesize($filepath));
        return readfile($filepath);
    }
    
    public static function video(string $name){
        $name = basename($name);
        $baseDir = realpath(__DIR__ . "/../storage/img/");
        $filepath = realpath($baseDir . DIRECTORY_SEPARATOR . $name);
        if(!$filepath || strpos($filepath, $baseDir) !== 0)
        {
            http_response_code(403);
            exit("access denied!!");
        }
        $mim = mime_content_type($filepath);
        header("Content-Type: $mim");
        header("Content-Length: " . filesize($filepath));
        return readfile($filepath);
    }

    public static function pdf(string $name){
        $name = basename($name);
        $baseDir = realpath(__DIR__ . "/../storage/img/");
        $filepath = realpath($baseDir . DIRECTORY_SEPARATOR . $name);
        if(!$filepath || strpos($filepath, $baseDir) !== 0)
        {
            http_response_code(403);
            exit("access denied!!");
        }
        $mim = mime_content_type($filepath);
        header("Content-Type: $mim");
        header("Content-Length: " . filesize($filepath));
        return readfile($filepath);
    }

}