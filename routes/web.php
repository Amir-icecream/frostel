<?php
use Core\Route;
use Core\Request;

$Router = new Route;
$Router->get('/' , 'HomeController');
$Router->get('/user/{id}' , 'UserController');
$Router->get('/product/{id}/{name}' , 'ProductController');



// supported methods : get , post , delete , update , put ,  patch                                                                                                              