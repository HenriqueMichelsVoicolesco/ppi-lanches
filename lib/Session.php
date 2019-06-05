<?php 


abstract class Session{

    public static function verificaLogin(){
        if (!isset($_SESSION['nome'])) {
            header('Location: ?pagina=home');
            exit;
        }
    }
}