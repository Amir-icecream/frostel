<?php 
namespace Config;

class ServePolicies{
    private static $policies;
    private static function init(){
        // key is directory or file and value is the policie 
        // policie can be all or none and can be any user role set in users table
        self::$policies = [
            // resource policies 
            'resource' => [
                'css'       => 'all',
                'js'        => 'all',
                'errors'    => 'none', // not safe to change
                'view'      => 'none', // not safe to change
            ],
            // storage policies
            'storage' => [
                'img'      => 'all',
                'pdf'      => 'all',
                'video'    => 'all',
            ],
            // file policies
            'files' => [
            ]
        ];
    }

    public static function get(){
        self::init();
        return self::$policies;
    }

}