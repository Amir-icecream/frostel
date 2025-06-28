<?php
namespace App\Controller;

use Core\Serve;
use Core\Request;

class StorageController{
    public function serve($file){
        $url = Request::Url();
        if(preg_match('#/storage/img/([^/]+)$#',$url))
        {
            Serve::img($file);
        }
        if(preg_match('#/storage/video/([^/]+)$#',$url))
        {
            Serve::video($file);
        }
        if(preg_match('#/storage/pdf/([^/]+)$#',$url))
        {
            Serve::pdf($file);
        }
    }
}