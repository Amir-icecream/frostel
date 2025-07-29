<?php
namespace Core;

use App\Model\User;
use Core\Cookie;
use Core\Session;

use function PHPSTORM_META\type;

class Auth{
    public static function register(array $credentials,bool $remember = false){
        if(!isset($credentials['password']) && empty($credentials['password']) &&
            !isset($credentials['username']) && empty($credentials['username']) )
        {
            return false;
        }
        if(self::userExists($credentials['username'])){
            return false;
        }
        $credentials['password'] = password_hash($credentials['password'], PASSWORD_DEFAULT);
        $remember_token = bin2hex(random_bytes(32));
        $credentials['remember_token'] = $remember_token;
        if($remember){
            self::set_cookie($remember_token);
        }else{
            self::set_session($remember_token);
        }

        return User::query()->create($credentials)->run();
    }
    public static function login(string $username, string $password,bool $remember = false){
        if(!self::userExists($username)){
            return false;
        }
        $user = User::query()->select(['password','remember_token'])->where('username', '=', $username)->run();
        $userpassword = $user[0]['password'] ?? null;
        if(!password_verify($password,$userpassword)){
            return false;
        }
        $remember_token = $user[0]['remember_token'] ?? '';
        if(empty($remember_token)){
            return false;
        }
        if($remember){
            return self::set_cookie($remember_token);
        }else{
            return self::set_session($remember_token);
        }
    }
    public static function loginViaEmail(string $email, string $password,bool $remember = false){
        if(!self::userExistsViaEmail($email)){
            return false;
        }
        $user = User::query()->select(['password','remember_token'])->where('email', '=', $email)->run();
        $userpassword = $user[0]['password'] ?? null;
        if(!password_verify($password,$userpassword)){
            return false;
        }
        $remember_token = $user[0]['remember_token'] ?? '';
        if(empty($remember_token)){
            return false;
        }
        if($remember){
            return self::set_cookie($remember_token);
        }else{
            return self::set_session($remember_token);
        }
    }
    public static function logout(){
        Session::unset($_ENV['SESSION_NAME'] ?? 'frostel_session');
        Cookie::unset($_ENV['COOKIE_NAME'] ?? 'frostel_token');
    }
    public static function deleteAccount(string $username){
        if(self::userExists($username)){
            $result = User::query()->delete()->where('username', '=', $username)->run();
            return is_array($result);
        }
        return false;
    }
    public static function userExists(string $username){
        $user = User::query()->select(['username'])->where('username','=',$username)->run();
        return !empty($user);    
    }
    public static function userExistsViaEmail(string $email){
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            return false;
        }
        $user = User::query()->select(['email'])->where('email','=',$email)->run();
        return !empty($user);    
    }
    public static function emailExists(string $email){
        $user = User::query()->select(['email'])->where('email','=',$email)->run();
        return !empty($user);
    }
    public static function role(string $username){
        $result = User::query()->select(['role'])->where('username', '=', $username)->run();
        if(isset($result[0]['role']) && !empty($result[0]['role'])){
            return $result[0]['role'];
        }
        return false;
    }

    public static function user(){
        $remember_token = null;

        $cookie_key = $_ENV['COOKIE_NAME'];
        $session_key = $_ENV['SESSION_NAME'];
        if(Session::has($session_key))
        {
            $remember_token = Session::get($session_key);
        }elseif(Cookie::exists($cookie_key)){
            $remember_token = Cookie::get($cookie_key);
        }else{
            return 'false';
        }

        $result = User::query()->select(['*'])->where('remember_token' ,'=', $remember_token)->run();
        if(!empty($result))
        {
            if(isset($result[0]['password']))
            {
                unset($result[0]['password']);
            }
            if(isset($result[0]['remember_token']))
            {
                unset($result[0]['remember_token']);
            }
            return $result[0];
        }
        return false;
    }

    public static function set_cookie(string $token){
        $token_name = $_ENV['COOKIE_NAME'] ?? 'frostel_token';
        $token_expire = $_ENV['COOKIE_EXPIRE'] ?? 31536000;
        $token_path = $_ENV['COOKIE_PATH'] ?? '/';
        $token_domain = $_ENV['COOKIE_DOMAIN'] ?? '';
        $token_secure = $_ENV['COOKIE_SECURE'] ?? true;
        $token_http_only = $_ENV['COOKIE_HTTP_ONLY'] ?? true;
        $token_same_site = $_ENV['COOKIE_SAME_SITE'] ?? 'lax';

        return Cookie::set($token_name,$token,$token_expire,$token_path,$token_domain,$token_secure,$token_http_only,$token_same_site);
    }
    public static function set_session($session){
        $session_key = $_ENV['SESSION_NAME'] ?? 'frostel_session';
        if(!Session::Has($session_key)){
            Session::set($session_key, $session);
            return Session::has($session_key);
        }
        return false;
    }
}