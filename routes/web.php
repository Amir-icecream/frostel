<?php
use Core\Route;

Route::get('/' , 'homeController@show');
Route::get('/user/{id}/{username}' , 'userController@show');
