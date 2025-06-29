<?php
namespace App\Controller;

use App\Model\User;
use Services\SmsServices;

class HomeController{
    public function show(){
        // $user = new User();
        $user = User::query()->update([
            'password' => 'dashd',
            'email' => ''
        ],true)->where('ID','=',3)->run();
        print_r($user);
        // foreach ($user as $key => $value) {
        //     print_r($key);
        //     print_r(' : ');
        //     print_r($value);
        //     print_r('</br>');
        // }
        return view('home');
    }
}