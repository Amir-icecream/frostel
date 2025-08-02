<?php
namespace App\Http\Middleware;

use Core\Csrf;
use Core\Session;

class SessionMiddleware{
    public function handle(){
        try {
            Session::start();
            Csrf::generateToken();
            return true;
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            abort(401);
        }
    }
}