<?php
use Core\Route;
use Core\Request;

return(view('home'));
$Router = new Route;
$Router->GET('/' , 'HomeController');
$Router->GET('/user/{id}' , 'HomeController');

$Router->Dispatch(Request::Url(),Request::Method());

