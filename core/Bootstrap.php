<?php
namespace Core;

class Bootstrap{
    private static $show_errors;

    public static function ApiCheck($url){
        return preg_match('#^/api(/|$)#',$url,$matches) === 1;
    }
    public static function php_configuration(){
        self::$show_errors = filter_var( $_ENV['SHOW_ERRORS'] ?? 'false' , FILTER_VALIDATE_BOOLEAN );
        $charset = $_ENV['CHARSET'] ?? 'UTF-8';
        $post_max_size = $_ENV['POST_MAX_SIZE'] ?? '8M';
        $upload_max_filesize = $_ENV['MAX_UPLOAD_SIZE'] ?? '8M';
        $max_file_uploads = $_ENV['MAX_FILE_UPLOADS'] ?? '20';
        $time_zone = $_ENV['TIMEZONE'] ?? 'UTC';

        error_reporting(E_ALL);
        if(self::$show_errors){
            ini_set('display_errors', '1');
            ini_set('display_startup_errors', '1');
        }
        else{
            ini_set('display_errors', '0');
            ini_set('display_startup_errors', '0');
        }
        $log_dir = __DIR__ . '/../config/logs/';
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
    public static function exeption_handeler(){
        self::$show_errors = filter_var($_ENV['SHOW_ERRORS'] ?? 'false', FILTER_VALIDATE_BOOLEAN);

        // Catch fatal errors
        register_shutdown_function(function () {
            $error = error_get_last();
            if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
                abort(500);
            }
        });

        // Catch uncaught exceptions
        set_exception_handler(function ($e) {
            if (!self::$show_errors) {
                abort(500);
            } else {
                echo "<h1>Uncaught Exception</h1>";
                echo "<pre>" . $e->getMessage() . "\n" . $e->getTraceAsString() . "</pre>";
            }
        });

        // Convert warnings/notices to exceptions
        set_error_handler(function ($severity, $message, $file, $line) {
            if (!(error_reporting() & $severity)) {
                return;
            }
            throw new \ErrorException($message, 0, $severity, $file, $line);
        });
    }
}