<?php
namespace Core;

use Config\ServePolicies;
use Core\Storage;
use Core\Resource;
use Core\Request;
use Core\Auth;
use Core\Middleware;
use Exception;

class Serve{
    public static function serveFile(string $from,bool $enforcePolicy = true){
        $from = strtolower($from);
        if(!filter_var($enforcePolicy , FILTER_VALIDATE_BOOL))
        {
            return self::serveByDirectory($from);
        }
        $policies = ServePolicies::get();
        $request = substr(Request::url(),strlen("/{$from}/"));
        $directories = explode('/',$request);
        $file = $directories[array_key_last($directories)];
        unset($directories[array_key_last($directories)]);
        // if file has policy
        if(array_key_exists($file,$policies['files']))
        {
            if( isset($policies['files'][$file]['middleware']) && !empty($policies['files'][$file]['middleware']) ){ // check file middleware
                $fileMiddleware = $policies['files'][$file]['middleware'];
                foreach ($fileMiddleware as $key => $middleware) {
                    if(empty($middleware)){
                        abort(403);
                    }elseif(filter_var(self::applyMiddleware($middleware),FILTER_VALIDATE_BOOL) === false){
                        abort(403);
                    }
                }
            }
            if(!isset($policies['files'][$file]['policy']) && empty($policies['files'][$file]['policy']))
            {
                return self::serveByDirectory($from);
            }
            
            $file_policy = strtolower($policies['files'][$file]['policy']);
            if($file_policy === 'deny'){
                abort(403);
            }elseif($file_policy === 'public'){
                return self::serveByDirectory($from);
            }else{
                $user_role = strtolower(Auth::role());
                if($user_role === $file_policy)
                {
                    return self::serveByDirectory($from);
                }else{
                    abort(403);
                }
            }
        }
        // if directory has policy
        $directory = end($directories);
        if( isset($policies[$from][$directory]['middleware']) && !empty($policies[$from][$directory]['middleware']) ){ // check directory middleware
            $directoryMiddleware = $policies[$from][$directory]['middleware'];
            foreach ($directoryMiddleware as $key => $middleware) {
                if(empty($middleware))
                {
                    abort(403);
                }elseif(filter_var(self::applyMiddleware($middleware),FILTER_VALIDATE_BOOL) === false){
                    abort(403);
                }
            }
        }

        if(!isset($policies[$from][$directory]['policy']) && empty($policies[$from][$directory]['policy']))
        {
            return self::serveByDirectory($from);
        }
        $directory_policy = strtolower($policies[$from][$directory]['policy']);
        if($directory_policy === 'deny'){
            abort(403);
        }elseif($directory_policy === 'public'){
            return self::serveByDirectory($from);
        }else{
            $user_role = strtolower(Auth::role());
            if($user_role === $directory_policy){
                return self::serveByDirectory($from);
            }
            else{
                abort(403);
            }
        }
    }
    
    public static function applyMiddleware(string $middleware){
        return Middleware::handel($middleware);
    }

    private static function serveByDirectory(string $directory){
        if($directory === "resource"){
            Resource::serve(Request::url());
        }
        elseif($directory === "storage"){
            Storage::serve(Request::url());
        }else{
            throw new Exception("Directory {$directory} does not exist or have not been configured");
        }
    }
}
