<?php
use Core\Route;
use Core\Middleware;

Route::get('/' , 'homeController@show');
Route::get('/user/{id}/{username}' , 'userController@show');
Route::get('/test' , 'testController@show');
Route::post('/form' , 'formController@show');

