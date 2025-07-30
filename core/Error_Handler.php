<?php
namespace Core;

class Error_Handler{
    private static $show_errors;

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
                require_once(__DIR__ . '/../resource/errors/error_handler.php');
            }
            error_log("Uncaught Exception: " . $e->getMessage() . "\n" . $e->getTraceAsString());
        });

        // Convert warnings/notices to exceptions
        set_error_handler(function ($severity, $message, $file, $line) {
            if (!(error_reporting() & $severity)) {
                return;
            }
            error_log("PHP Error: [$severity] $message in $file on line $line");
            throw new \ErrorException($message, 0, $severity, $file, $line);
        });
    }
}