<?php 


abstract class Session{

    private static $status;

    public static function verificaLogin(){
        if (session_status() == PHP_SESSION_ACTIVE) {
            self::$status = true;
        } else {
            self::$status = false;
        }

        return self::$status;
    }
}