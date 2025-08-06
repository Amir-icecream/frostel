<?php
namespace Core\Database;

use Dotenv\Dotenv;

class Schema{
    public static function create(string $table,callable $func){
        if(php_sapi_name() === 'cli'){
            echo("creating table {$table}" . PHP_EOL);
        }

        $bluePrint = new BluePrint($table);

        $func($bluePrint);

        self::build($bluePrint);
    }
    public static function dropIfExists(string $table){
        if(php_sapi_name() === 'cli'){
            echo("dropping table {$table}" . PHP_EOL);
        }
        
        $sql = 'DROP TABLE IF EXISTS ' . $table . ';';
        $DB = new Database;
        $result = $DB->transaction(function($DB) use ($sql){
            $state = $DB->prepare($sql);
            return $state->execute();
        });

        if(php_sapi_name() === 'cli'){
            if($result === true){
                echo("dropped successfully." . PHP_EOL);
            }else{
                $error = $DB->get_db()->errorInfo();
                echo "Migration failed: " . ($error[2] ?? 'Unknown error') . PHP_EOL;
            }
        }
    }

    protected static function build($bluePrint){
    
        $sql = $bluePrint->sql();
        $DB = new Database;
        $result = $DB->transaction(function($DB) use ($sql){
            $state = $DB->prepare($sql);
            return $state->execute();
        });
    
        if(php_sapi_name() === 'cli'){
            if($result === true){
                echo("Migrated successfully" . PHP_EOL);
            }else{
                $error = $DB->get_db()->errorInfo();
                echo "Migration failed: " . ($error[2] ?? 'Unknown error') . PHP_EOL;
            }
        }
    }
}