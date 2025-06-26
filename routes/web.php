<?php
use Core\Route;

Route::get('/' , 'HomeController@showa');
Route::get('/user/{id}/{name}' , 'UserController@show');

Route::get('/storage/img/{img}','StorageController@serve');
Route::get('/storage/video/{video}','StorageController@serve');
Route::get('/storage/pdf/{pdf}','StorageController@serve');
