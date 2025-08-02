<?php
namespace App\Http\Controller;

use Core\Csrf;

class testController {
    public function show()
    {
        return view('form');
    }
}