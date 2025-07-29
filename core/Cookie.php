<?php
namespace Core;

class Cookie{
    /**
     * Set a cookie with the given parameters.
     * @param string $key The name of the cookie.
     * @param string $value The value of the cookie.
     * @param int $expire The expiration time of the cookie in seconds.
     * @param string $path The path on the server in which the cookie will be available
     * @param string $domain The domain that the cookie is available to.
     * @param bool $secure Indicates that the cookie should only be transmitted over a secure HTTPS connection.
     * @param bool $http_only When true, the cookie will be made accessible only through the HTTP protocol.
     * @param string $same_site Controls whether a cookie is sent with cross-site requests.
     * @return bool Returns true on success or false on failure.
     */
    public static function set($key,$value,$expire,$path = '/',$domain = '',$secure = true,$http_only = true,$same_site = 'lax'){
        return setcookie($key,$value,[
            'expires' => time() + $expire,  
            'path' => $path,
            'domain' => $domain,
            'secure' => $secure,
            'httponly' => $http_only,
            'samesite' => $same_site]);
    }
    /**
     * Unset a cookie by its name.
     * @param string $key The name of the cookie to unset.
     * @return bool Returns true on success or false on failure.
     */
    public static function unset($key){
        if(self::exists($key)){
            return self::set($key, '', time() - 3600);
        }
        return false;
    }
    /**
     * Get the cookie by its name.
     * @param string $key The name of the cookie.
     * @return mixed Returns the value of the cookie if it exists, or false if it does not.
     */
    public static function get($key){
        if(self::exists($key)){
            return $_COOKIE[$key];
        }
        return false;
    }
    /**
     * Check if a cookie exists.
     * @param string $key The name of the cookie.
     * @return bool Returns true if the cookie exists, false otherwise.
     */
    public static function exists($key){
        return isset($_COOKIE[$key]);
    }

}