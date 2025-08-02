<?php
namespace Core;

use Exception;

class Template{
    public static function buildFromStub(string $stubPath , string $outputPath , array $replaceData){
        $stubPath = realpath(__DIR__ . '/../templates/' . ltrim($stubPath,'/') . '.stub');
        if($stubPath === false){
            return ("no such directory found in :  {$stubPath}");
        }
        $stubFile = file_get_contents($stubPath);
        if($stubFile === false){
            return ("no such stub file found in directory:  {$stubPath}");
        }

        foreach ($replaceData as $key => $value) {
            $stubFile = str_replace('{{' . $key . '}}',$value,$stubFile);
        }

        $outputPath = __DIR__ . '/../' . ltrim($outputPath,'/');
        if(file_exists($outputPath)){
            return('file already exists');
        }
        if(file_put_contents($outputPath,$stubFile) === false){
            return ("can not crete template file in : {$outputPath}");
        }

        return true;
    }
}