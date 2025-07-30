<?php
namespace App\Controller;

use App\Model\User;
use Illuminate\Validation\Rules\Email;
use Services\SmsServices;
use Services\EmailService;
use Core\Auth;
use Core\Cookie;
use Core\Session;
use Config\TelegramEndPoints;
use Core\Request;
use Services\TelegramServices;

class HomeController{
    public function show(){
        // $user = User::query()->select(['*'])->join('products','id','userid')->where('users.id','=',1)->orderby('users.id')->reverse()->run();
        // foreach ($user as $key => $value) {
        //     print_r($key);
        //     print_r(' : ');
        //     print_r($value);
        //     print_r('</br>');
        // }

        // print_r(EmailService::sendEmail(
        //     'amir.icecream.1385@gmail.com',
        //     'سلام از Dtoy 👋',
        //     '',
        //     'ammsss.2020@gmail.com',
        //     'Dtoy Store'
        // ));
        // $username = 'amiras1a';
        // if(!Auth::userExists($username))
        // {
        //     $result = Auth::register([
        //         'username' => $username,
        //         'password' => 'Amirmohammad1385',
        //     ],true);
        // }
        // else{
        //     $result = 'user already exists';
        // }
        
        // print_r($result);
        // echo Session::unset('frostel_session');
        // echo Auth::loginViaEmail('amir.icecream.1385@gmail.com','Amirmohammad1385',true);
        // print_r(TelegramEndPoints::getChatAdministrators());
        // print_r(Request::agent());
        return view('home');
    }
}