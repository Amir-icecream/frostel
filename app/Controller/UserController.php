<?php
namespace App\Controller;

class UserController {
    public function show($id,$name){
        // $res = ['response' => true , 'text' => 'amir'];
        // header('Content-Type: application/json');
        // echo json_encode($res);

        view('user',['id' => $id ,'name' => $name]);
    }
}