<?php
use Core\Route;

Route::get('/' , 'HomeController@show');
Route::get('/user/{id}' , 'UserController');

Route::get('/storage/img/{img}','StorageController');
Route::get('/storage/video/{video}','StorageController');
Route::get('/storage/pdf/{pdf}','StorageController');