<?php




class Cookie {
    //criacao 
    public static function set($name, $value, $expiry = 3600) {
        if (setcookie($name, $value, time() + $expiry, "/", "", false, true)){
            return true;
        }
        return false;
    }

    //obter
    public static function get($name) {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
    }

    //verificacao 
    public static function exists($name) {
        return isset($_COOKIE[$name]);
    } 

    //apagar
    public static function deletar($name) {
        if (self::exists($name)) {
            setcookie($name, "", time() - 3600, "/", "", false, true);
            return true;
        }
    }



}