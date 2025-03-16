<?php
use Core\Route;
use Core\Request;

$Router = new Route;
// return(view('home'));
$Router->get('/' , 'HomeController')->middleware('auth');
$Router->get('/user' , 'HomeController')->middleware('f');
// $Router->get('/user/{id}' , 'HomeController');

$Router->Dispatch(Request::Url(),Request::Method());
