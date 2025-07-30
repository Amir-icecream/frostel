<?php
namespace Core;

use Core\Mim;

class Storage{
    public static function serve($request){
        $request = substr($request,strlen('/storage'));
        $request = 'file/' . ltrim($request , '/');
        $storageDir = realpath(__DIR__ . '/../storage/');
        $filepath = realpath($storageDir . '/' . ltrim($request,'/'));
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
        }else{
            abort(404);
        }

    }

    

}