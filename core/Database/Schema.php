<?php
namespace Core\Database;

use Dotenv\Dotenv;

class Schema{
    private static function init(){
        try {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
            $dotenv->load();
        } catch (\Exception $e) {
            throw new \Exception("Environment load error : " . $e->getMessage());
        }
    }

    public static function create(string $table,callable $func){
        echo("creting table {$table}" . PHP_EOL);

        self::init();

        $bluePrint = new BluePrint($table);

        $func($bluePrint);

        self::build($bluePrint);
    }

    protected static function build($bluePrint){
        // create table
        $sql = $bluePrint->sql();
        $DB = new Database;
        $result = $DB->transaction(function($DB) use ($sql){
            $state = $DB->prepare($sql);
            return $state->execute();
        });

        if($result === true){
            echo("Migrated successfully" . PHP_EOL);
        }else{
            $error = $DB->get_db()->errorInfo();
            echo "Migration failed: " . ($error[2] ?? 'Unknown error') . PHP_EOL;
        }

    }

    public static function dropIfExists(string $table){
        echo("dropping table {$table}" . PHP_EOL);

        self::init();

        $sql = 'DROP TABLE IF EXISTS ' . $table . ';';
        $DB = new Database;
        $result = $DB->transaction(function($DB) use ($sql){
            $state = $DB->prepare($sql);
            return $state->execute();
        });
        if($result === true){
            echo("dropped successfully." . PHP_EOL);
        }else{
            $error = $DB->get_db()->errorInfo();
            echo "Migration failed: " . ($error[2] ?? 'Unknown error') . PHP_EOL;
        }
    }
}