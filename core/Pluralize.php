<?php
namespace Core;

use Core\Loader;

class Pluralize{
    public static function do($value){
        $value = strtolower($value);
        $Pluralize = Loader::config('Pluralize');
        $irregular = $Pluralize['irregular'];
        $Uncountable = $Pluralize['Uncountable'];
        if(in_array($value,$Uncountable)){
            return $value;
        }
        if(array_key_exists($value,$irregular)){
            return($irregular[$value]);
        }
        $specialEndings = ['ch', 'sh', 'x', 'z', 's'];
        foreach ($specialEndings as $key => $end) {
            if(str_ends_with($value,$end)){
                return $value . 'es';
            }
        }
        if(str_ends_with($value,'y') && !in_array($value[strlen($value) - 2], ['a', 'e', 'i', 'o', 'u'])){
            return substr($value , 0 , -1) . 'ies';
        }

        return $value . 's';
    }
}