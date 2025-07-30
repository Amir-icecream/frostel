<?php
namespace App\Controller;

class UserController {
    public function show($id,$username){
        return view('user',['id' => $id ,'username' => $username]);
    }
}