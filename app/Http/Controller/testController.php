<?php
namespace App\Http\Controller;

use App\Model\User;
use Core\Auth;
use Core\Database\Model;

class testController {
    public function show()
    {
        print_r(str_pad(2,6,0,STR_PAD_LEFT));
    }
}