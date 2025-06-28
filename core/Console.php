<?php 
namespace Core;

class console{
    public static function help(){
        $help = [
            "\n",
            "hi here is a list of console command that you can use for better experince\n\n",
            " [0] view-fresh : delte the cache of views\n",
            " [1] delete-logs : delete the app logs file\n",
            " [2] make:controller <controller_name> : create a controller file with the given name\n",
            " [3] make:model <model_name> : create a model file with the given name\n",
            " [4] help : show this help message\n\n"
        ];
        foreach ($help as $value) {
            echo($value);
        }
        return(true);
    }
    public static function make_controller($controller_name){
        try {
            if(empty($controller_name))
            {
                echo("please enter a controller name\n");
                return false;
            }

            $template_dir = __DIR__ . '/../templates/controller/default.stub';
            $output_dir = __DIR__ . '/../app/Controller/' . $controller_name . '.php';

            if(!is_dir(__DIR__ . '/../app/Controller/'))
            {
                mkdir(dirname($output_dir), 0755, true);
            }
            if(file_exists($output_dir))
            {
                echo("controller file already exist, please choose another name\n");
                return false;
            }
            $template = file_get_contents($template_dir);
            $template = str_replace('{{class}}', $controller_name, $template);
            file_put_contents($output_dir, $template);
            echo("controller file created successfully\n");
        } catch (\Throwable $th) {
            echo("cannot create controller file\n");
            return false;
        }
    }
    public static function make_model($model_name){
        try {
            if(empty($model_name))
            {
                echo("please enter a controller name\n");
                return false;
            }

            $template_dir = __DIR__ . '/../templates/model/default.stub';
            $output_dir = __DIR__ . '/../app/Model/' . $model_name . '.php';

            if(!is_dir(__DIR__ . '/../app/Model/'))
            {
                mkdir(dirname($output_dir), 0755, true);
            }
            if(file_exists($output_dir))
            {
                echo("model file already exist, please choose another name\n");
                return false;
            }
            $template = file_get_contents($template_dir);
            $template = str_replace('{{class}}', $model_name, $template);
            file_put_contents($output_dir, $template);
            echo("model file created successfully\n");
        } catch (\Throwable $th) {
            echo("cannot create model file\n");
            return false;
        }
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