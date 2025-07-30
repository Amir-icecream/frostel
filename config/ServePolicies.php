<?php 
namespace Config;

class ServePolicies{
    private static $policies;
    private static function init(){
        // key is directory or file and value is the policie 
        // policie can be public or deny and can be any user role set in users table
        self::$policies = [
            // resource policies 
            'resource' => [
                'css' => [
                    'policy' => 'public',
                    'middleware' =>[

                    ],
                ],
                'js' => [
                    'policy' => 'public',
                    'middleware' => [
                        
                    ]
                ],
                'errors' => [ // not safe to change
                    'policy' => 'deny',
                    'middleware' => [

                    ]
                ], 
                'view' => [ // not safe to change
                    'policy' => 'deny',
                    'midleware' => [

                    ]
                ], 

            ],
            // storage policies
            'storage' => [
                'img' => [
                    'policy' => 'public',
                    'middleware' => [
                        
                    ]
                ],
                'pdf' => [
                    'policy' => 'public',
                    'middleware' => [

                    ]
                ],
                'video' => [
                    'policy' => 'public',
                    'middleware' => [

                    ]
                ],

            ],
            // file policies
            'files' => [
                'Frostel.png' => [
                    'policy' => 'public',
                    'middleware' => [

                    ]
                ]
            ]
        ];
    }

    public static function get(){
        self::init();
        return self::$policies;
    }

}