<?php
namespace App\Controller;

use App\Model\UserModel;

class HomeController{
    public function show(){
        $user = new UserModel();
        return view('home');
    }
}