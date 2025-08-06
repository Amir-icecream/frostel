<?php
namespace Core\Database;

use DirectoryIterator;

class Migrator{
    public function run(){
        $directory = realpath(__DIR__ . '/../../database/migrations/');
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
    public function down(){
        $directory = realpath(__DIR__ . '/../../database/migrations/');
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
}