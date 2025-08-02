<?php
namespace App\Http\Controller;

use Core\Auth;

class homeController {
    public function show()
    {
        return view('home');
    }
}