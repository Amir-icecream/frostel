<?php
use Core\Route;
use Core\Request;

$Router = new Route;
// $Router->get('/' , 'HomeController');
view('home');
$Router->get('/user/{id}' , 'HomeController1');
$Router->get('/cart/{id}/{value}' , 'HomeController');
// $Router->get('/user/{id}' , 'HomeController');

$Router->Dispatch(Request::Url(),Request::Method());


