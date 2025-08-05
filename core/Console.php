<?php 
namespace Core;

use Core\Template;
use Directory;
use DirectoryIterator;

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
    // make commands
    public static function make_view($view_name){
        $stubPath = "/framework/view/default";
        $outputPath = "/resource/view/$view_name.blade.php";
        $replaceData = [];
        $result = Template::buildFromStub($stubPath , $outputPath , $replaceData);
        if($result !== true)
        {
            echo($result);
            return;
        }
        echo("created successfuly" . PHP_EOL);
        return;
    }
    public static function make_controller($controller_name){
        $stubPath = "/framework/controller/default";
        $outputPath = "/app/Http/controller/$controller_name". "Controller" .".php";
        $replaceData = ['class' => $controller_name . 'Controller'];
        $result = Template::buildFromStub($stubPath , $outputPath , $replaceData);
        if($result !== true)
        {
            echo($result);
            return;
        }
        echo("created successfuly" . PHP_EOL);
        return;
    }
    public static function make_model($model_name){
        $stubPath = "/framework/model/default";
        $outputPath = "/app/model/$model_name.php";
        $replaceData = ['class' => $model_name];
        $result = Template::buildFromStub($stubPath , $outputPath , $replaceData);
        if($result !== true)
        {
            echo($result);
            return;
        }
        echo("created successfuly" . PHP_EOL);
        return;
    }
    public static function make_middleware($middleware_name){
        $stubPath = "/framework/middleware/default";
        $outputPath = "/app//Http/middleware/$middleware_name". "Middleware" .".php";
        $replaceData = ['class' => $middleware_name . 'Middleware'];
        $result = Template::buildFromStub($stubPath , $outputPath , $replaceData);
        if($result !== true)
        {
            echo($result);
            return;
        }
        echo("created successfuly" . PHP_EOL);
        return;
    }
    public static function make_migration($migration_name){
        $directory = realpath(__DIR__ . '/../database/migrations/');
        if($directory === false){
            echo "directory database/migrations not found" . PHP_EOL;
            return;
        }
        $fileCount = 0;
        foreach (new DirectoryIterator($directory) as $file) {
            if(!$file->isFile() || $file->getExtension() !== 'php'){
                continue;
            }
            $fileCount++;
        }
        $nextNumber = str_pad($fileCount + 1, 6, '0', STR_PAD_LEFT); // نتیجه: 000001
        $migration = '0001_01_01_' . $nextNumber . '_' . $migration_name . '.php';
        $result = Template::buildFromStub('//migration/default','/database/migrations/' . $migration);
        if($result !== true){
            echo $result . PHP_EOL;
        }else{
            echo('created successfully' . PHP_EOL);
        }
    }
    // migration
    public static function migrateUp(){
        $directory = realpath(__DIR__ . '/../database/migrations/');
        if($directory === false){
            echo "directory database/migrations not found" . PHP_EOL;
            return;
        } 
        $files_path = [];
        foreach (new DirectoryIterator($directory) as $file) {
            if(!$file->isFile() || $file->getExtension() !== 'php'){
                continue;
            }
            array_push($files_path,$file->getPathname());
        }

        sort($files_path);

        foreach ($files_path as $file) {
            $migration = include($file);
            if(!is_object($migration)){
                continue;
            }
            if(!method_exists($migration,'up')){
                continue;
            }
            $migration->up();
        }
    }
    public static function migrateDown(){
        $directory = realpath(__DIR__ . '/../database/migrations/');
        if($directory === false){
            echo "directory database/migrations not found" . PHP_EOL;
            return;
        } 
        $files_path = [];
        foreach (new DirectoryIterator($directory) as $file) {
            if(!$file->isFile() || $file->getExtension() !== 'php'){
                continue;
            }
            array_push($files_path,$file->getPathname());
        }

        sort($files_path);
        $files_path = array_reverse($files_path);

        foreach ($files_path as $file) {
            $migration = include($file);
            if(!is_object($migration)){
                continue;
            }
            if(!method_exists($migration,'down')){
                continue;
            }
            $migration->down();
        }
    }

    // fresh view cache
    public static function view_fresh(){
        $dir = __DIR__ . "/../storage/framework/view/";
        $files = glob($dir.'*');

        foreach ($files as $file) {
            if(is_file($file))
            {
                unlink($file);
            }
        }
        echo("all view cache deleted successfully" . PHP_EOL);
        return true;
    }
    // fresh app.log file
    public static function delete_logs(){
        $dir = __DIR__ . '/../storage/logs/app.log';
        if(file_exists($dir))
        {
            unlink($dir);
            echo("all logs deleted successfully" . PHP_EOL);
            return true;
        }
        else
        {
            echo("logs file not found" . PHP_EOL);
            return false;
        }
    }
}