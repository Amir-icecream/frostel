<?php
namespace Core;

use Config\ServePolicies;
use Core\Storage;
use Core\Resource;
use Core\Request;
use Core\Auth;
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
        if(array_key_exists($file,$policies['files']))
        {
            if(!isset($policies['files'][$file]) && empty($policies['files'][$file]))
            {
                return self::serveByDirectory($from);
            }
            $file_policy = strtolower($policies['files'][$file]);
            if($file_policy === 'none'){
                abort(403);
            }elseif($file_policy === 'all'){
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
        $directory = end($directories);
        if(!isset($policies[$from][$directory]) && empty($policies[$from][$directory]))
        {
            return self::serveByDirectory($from);
        }
        
        $directory_policy = strtolower($policies[$from][$directory]);
        if($directory_policy === 'none'){
            abort(403);
        }elseif($directory_policy === 'all'){
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