<?php
namespace App\Http\Controller;

use Core\Csrf;

class formController {
    public function show()
    {
        print_r(Csrf::validate());

    }
}