<?php 
namespace Core;

use Core\Template;

class console{
    public static function help(){
        $help = [
            "\n",
            "hi here is a list of console command that you can use for better experince\n\n",
            " [1] view-fresh : delte the cache of views\n",
            " [2] delete-logs : delete the app logs file\n",
            " [3] make:controller <controller_name> : create a controller file with the given name\n",
            " [4] make:model <model_name> : create a model file with the given name\n",
            " [0] help : show this help message\n\n"
        ];
        foreach ($help as $value) {
            echo($value);
        }
        return(true);
    }
    public static function make_view($view_name){
        $stubPath = "/view/default";
        $outputPath = "/resource/view/$view_name.blade.php";
        $replaceData = [];
        $result = Template::buildFromStub($stubPath , $outputPath , $replaceData);
        if($result !== true)
        {
            echo($result);
            return;
        }
        echo("created successfuly");
        return;
    }
    public static function make_controller($controller_name){
        $stubPath = "/controller/default";
        $outputPath = "/app/Http/controller/$controller_name". "Controller" .".php";
        $replaceData = ['class' => $controller_name . 'Controller'];
        $result = Template::buildFromStub($stubPath , $outputPath , $replaceData);
        if($result !== true)
        {
            echo($result);
            return;
        }
        echo("created successfuly");
        return;
    }
    public static function make_model($model_name){
        $stubPath = "/model/default";
        $outputPath = "/app/model/$model_name.php";
        $replaceData = ['class' => $model_name];
        $result = Template::buildFromStub($stubPath , $outputPath , $replaceData);
        if($result !== true)
        {
            echo($result);
            return;
        }
        echo("created successfuly");
        return;
    }
    public static function make_middleware($middleware_name){
        $stubPath = "/middleware/default";
        $outputPath = "/app//Http/middleware/$middleware_name". "Middleware" .".php";
        $replaceData = ['class' => $middleware_name . 'Middleware'];
        $result = Template::buildFromStub($stubPath , $outputPath , $replaceData);
        if($result !== true)
        {
            echo($result);
            return;
        }
        echo("created successfuly");
        return;
    }
    public static function view_fresh(){
        $dir = __DIR__ . "/../storage/framework/view/";
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
        $dir = __DIR__ . '/../storage/logs/app.log';
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