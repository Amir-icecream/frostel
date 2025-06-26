<?php 
namespace Core;

class console{
    public static function help(){
        $help = [
            "\n",
            "hi here is a list of console command that you can use for better experince\n\n",
            "view-fresh : delte the cache of views\n",
            "delete-logs : delete the app logs file\n",
            "help : show this help message\n\n"
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
        echo("all view cache deleted successfully\n");
        return true;
    }
    public static function delete_logs(){
        $dir = __DIR__ . '/../config/logs/app.log';
        if(file_exists($dir))
        {
            unlink($dir);
            echo("all logs deleted successfully\n");
            return true;
        }
        else
        {
            echo("logs file not found\n");
            return false;
        }
    }
}