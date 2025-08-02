<?php
namespace App\Http\Controller;

class UserController {
    public function show($id,$username){
        return view('user',['id' => $id ,'username' => $username]);
    }
}