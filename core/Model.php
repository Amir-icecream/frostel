<?php
namespace Core;
use Config\Database;

class Model extends Database{
    public function __construct() {
        $db = new Database;
        $users = $db->transaction(function($db){
            $stat = $db->prepare("SELECT * FROM users");
            $stat->execute();
            return $stat->fetchAll();
        });
        foreach ($users as $key => $value) {
            print_r($users[$key]['ID']);
            print_r('</br>');
        }
    }
}