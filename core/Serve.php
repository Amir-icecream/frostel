<?php
namespace Core;

use Config\ServePolicies;
use Core\Storage;
use Core\Resource;
use Core\Request;
use Core\Auth;
use Directory;
use Exception;

class Serve{
    public static function file(string $from,bool $withPolicie = true){
        // serve resource
        if(strtolower($from) === 'resource')
        {
            if(!filter_var($withPolicie,FILTER_VALIDATE_BOOL))
            {
                return Resource::serve(Request::url());
            }
            $policies = ServePolicies::get();
            $request = substr(Request::url(),strlen('/resource/'));
            $directories = explode('/',$request);
            $file = $directories[array_key_last($directories)];
            unset($directories[array_key_last($directories)]);
            if(array_key_exists($file,$policies['files']))
            {
                if(!isset($policies['files'][$file]) && empty($policies['files'][$file]))
                {
                    return Resource::serve(Request::url());
                }
                $file_policie = strtolower($policies['files'][$file]);
                if($file_policie === 'none'){
                    abort(403);
                }elseif($file_policie === 'all'){
                    return Resource::serve(Request::url());
                }else{
                    $user_role = strtolower(Auth::role());
                    if($user_role === $file_policie)
                    {
                        return Resource::serve(Request::url());
                    }else{
                        abort(403);
                    }
                }
            }
            $directory = end($directories);
            if(!isset($policies['resource'][$directory]) && empty($policies['resource'][$directory]))
            {
                return Resource::serve(Request::url());
            }
            
            $directory_policie = strtolower($policies['resource'][$directory]);
            if($directory_policie === 'none'){
                abort(403);
            }elseif($directory_policie === 'all'){
                return Resource::serve(Request::url());
            }else{
                $user_role = strtolower(Auth::role());
                if($user_role === $directory_policie){
                    return Resource::serve(Request::url());
                }
                else{
                    abort(403);
                }
            }
        }
        // serve storage
        elseif(strtolower($from) === 'storage'){
            if(!filter_var($withPolicie,FILTER_VALIDATE_BOOL))
                {
                    return Storage::serve(Request::url());
                }
            $policies = ServePolicies::get();
            $request = substr(Request::url(),strlen('/storage/'));
            $directories = explode('/',$request);
            $file = $directories[array_key_last($directories)];
            unset($directories[array_key_last($directories)]);
            if(array_key_exists($file,$policies['files']))
            {
                if(!isset($policies['files'][$file]) && empty($policies['files'][$file]))
                {
                    return Storage::serve(Request::url());
                }
                $file_policie = strtolower($policies['files'][$file]);
                if($file_policie === 'none'){
                    abort(403);
                }elseif($file_policie === 'all'){
                    return Storage::serve(Request::url());
                }else{
                    $user_role = strtolower(Auth::role());
                    if($user_role === $file_policie)
                    {
                        return Storage::serve(Request::url());
                    }else{
                        abort(403);
                    }
                }
            }
            $directory = end($directories);
            if(!isset($policies['storage'][$directory]) && empty($policies['storage'][$directory]))
            {
                return Storage::serve(Request::url());
            }
            $directory_policie = strtolower($policies['storage'][$directory]);
            if($directory_policie === 'none'){
                abort(403);
            }elseif($directory_policie === 'all'){
                return Storage::serve(Request::url());
            }else{
                $user_role = strtolower(Auth::role());
                if($user_role === $directory_policie){
                    return Storage::serve(Request::url());
                }
                else{
                    abort(403);
                }
            }
        }else{
            throw new Exception("Directory {$from} does not exist or have not been configured");
        }
    }
}