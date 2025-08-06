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

        User::query()->create($credentials)->run() === false;
        return true;
    }
    // login user with specific credentials
    public static function attempt(array $credentials , bool $remember = false){
        if (!isset($credentials['password']) || (!isset($credentials['username']) && !isset($credentials['email']))) {
            return false;
        }
        $password = $credentials['password'];
        unset($credentials['password']);
        $model = User::query()->select(['password','remember_token'])->where('remember_token','IS NOT NULL');
        foreach ($credentials as $col => $value) {
            $model->andwhere($col,'=',$value);
        }
        $model->limit(1)->run();
        $user = $model->getResult();
        if(empty($user)){
            return false;
        }
        $passwordHash = $user->password;
        if(!password_verify($password,$passwordHash)){
            return false;
        }
        $remember_token = $user->remember_token;
        if($remember){
            self::set_cookie($remember_token);
        }else{
            self::set_session($remember_token);
        }

        return true;
    }
    public static function login(object $user,bool $remember = false): bool{
        if( empty($user) || !isset($user->username) || !isset($user->remember_token) ){
            return false;
        }
        $remember_token = $user->remember_token;
        if($remember){
            self::set_cookie($remember_token);
        }else{
            self::set_session($remember_token);
        }

        return true;
    }
    public static function loginViaEmail(string $email, string $password,bool $remember = false){
        if(!self::userExistsViaEmail($email)){
            return false;
        }
        $user = User::query()->select(['password','remember_token'])->where('email', '=', $email)->run();
        $userpassword = $user->password ?? null;
        if(!password_verify($password,$userpassword)){
            return false;
        }
        $remember_token = $user->remember_token ?? '';
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
        User::query()->delete()->where('username', '=', $username)->run();
        return true;
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
    public static function role(){
        $user = self::user();
        if(isset($user->role) && !empty($user->role)){
            return $user->role;
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

        $result = User::query()->select(['*'])->where('remember_token' ,'=', $remember_token)->limit(1)->run();
        if(!empty($result))
        {
            if(isset($result->password))
            {
                unset($result->password);
            }
            if(isset($result->remember_token))
            {
                unset($result->remember_token);
            }
            return $result;
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

        return Cookie::set($token_name,
        $token,
        $token_expire,
        $token_path,
        $token_domain,
        $token_secure,
        $token_http_only,
        $token_same_site);
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