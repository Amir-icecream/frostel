<?php 
namespace Core;

class console{
    public static function help(){
        $help = [
            "hello dear Customer here is a list of console command that you can use for better experince\n",
            "view-fresh : delte the cache of views\n"
        ];
        foreach ($help as $value) {
            echo($value);
        }
        return(true);
    }
    public static function view_fresh(){
        $dir = __DIR__ . "/../config/cache/view/";
        $files = glob($dir.'*');

        foreach ($files as $file) {
            if(is_file($file))
            {
                unlink($file);
            }
        }
        return true;
    }
}