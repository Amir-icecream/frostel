<?php
use Core\Serve;
use Core\Request;

$url = Request::Url();
if(preg_match('#/storage/img/([^/]+)$#',$url))
{
    Serve::img($img);
}
if(preg_match('#/storage/video/([^/]+)$#',$url))
{
    Serve::video($video);
}
if(preg_match('#/storage/pdf/([^/]+)$#',$url))
{
    Serve::pdf($pdf);
}