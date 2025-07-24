<?php
namespace App\Controller;

use App\Model\User;
use Services\SmsServices;

class HomeController{
    public function show(){
        $user = User::query()->select(['*'])->join('products','id','userid')->where('users.id','=',1)->orderby('users.id')->reverse()->run();
        foreach ($user as $key => $value) {
            print_r($key);
            print_r(' : ');
            print_r($value);
            print_r('</br>');
        }
        return view('home');
    }
}