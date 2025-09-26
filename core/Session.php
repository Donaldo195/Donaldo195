<?php





class Session {

    //inicia a sessao
    public static function start() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    //definir valor da sessao
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    //apagar o valor da sessao
    public static function get($key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    //verificar se existe
    public static function exists($key) {
        return isset($_SESSION[$key]);
    }

    //apagar variavel da sessao
    public static function delete($key) {
        if (self::exists($key)) {
            unset($_SESSION[$key]);
        }
    }

    //destroir toda a sessao
    public static function destroy() {
        session_unset();
        session_destroy();
    }




}