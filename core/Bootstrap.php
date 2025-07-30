<?php
namespace Core;
use Core\Request;
use Core\Serve;

class Bootstrap{
    public static function php_configuration(){
        $show_errors = filter_var( $_ENV['SHOW_ERRORS'] ?? 'false' , FILTER_VALIDATE_BOOLEAN );
        $charset = $_ENV['CHARSET'] ?? 'UTF-8';
        $post_max_size = $_ENV['POST_MAX_SIZE'] ?? '8M';
        $upload_max_filesize = $_ENV['MAX_UPLOAD_SIZE'] ?? '8M';
        $max_file_uploads = $_ENV['MAX_FILE_UPLOADS'] ?? '20';
        $time_zone = $_ENV['TIMEZONE'] ?? 'UTC';

        error_reporting(E_ALL);
        if($show_errors){
            ini_set('display_errors', '1');
            ini_set('display_startup_errors', '1');
        }
        else{
            ini_set('display_errors', '0');
            ini_set('display_startup_errors', '0');
        }
        $log_dir = __DIR__ . '/../storage/logs/';
        if(!is_dir($log_dir)){
            mkdir($log_dir, 0755, true);
        }
        ini_set('log_errors', '1');
        ini_set('error_log', $log_dir . 'app.log');

        ini_set('default_charset', $charset);
        ini_set('post_max_size',$post_max_size);
        ini_set('upload_max_filesize', $upload_max_filesize);
        ini_set('max_file_uploads', $max_file_uploads);
        ini_set('expose_php', '0');
        ini_set('allow_url_include', '0');
        date_default_timezone_set($time_zone);
        
    }

    public static function initializeRequest(){
        if(Request::isResourceRequest())
        {
            return Serve::file('resource');
        }elseif(Request::isStorageRequest())
        {
            return Serve::file('storage');
        }elseif(Request::isApiRequest()){
            require_once(__DIR__ . "/../routes/api.php");
            return Route::dispatch(Request::url(),Request::method());
        }else{
            Session::start();
            require_once(__DIR__ . "/../routes/web.php");
            return Route::dispatch(Request::url(),Request::method());
        }
    }
}