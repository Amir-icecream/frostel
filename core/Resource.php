<?php
namespace Core;

use Core\Auth;
use Core\Mim;

class Resource{
    public static function serve($request){
        $baseDir = realpath(__DIR__ . '/../');
        $filepath = realpath($baseDir . '/' . ltrim($request,'/'));
        $storageDir = realpath(__DIR__ . '/../resource');
        if($filepath && strpos($filepath,$storageDir) === 0)
        {
            if(is_file($filepath)){
                $mim = Mim::getFileMim($filepath);
                header("Content-Type: $mim");
                header("Content-Length: " . filesize($filepath));
                header('Cache-Control: public, max-age=86400');
                header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');    
                if(!readfile($filepath)){
                    abort(500);
                }
                return true;
            }
            if(is_dir($filepath)){
                abort(403);
            }
            abort(404);
        }

         abort(404);
    }
}