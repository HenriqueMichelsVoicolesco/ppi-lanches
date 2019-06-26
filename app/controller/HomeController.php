<?php

class HomeController
{

    public static function index()
    {

        try {

            if (!isset($_SESSION['nome'])) {

                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);

                $variaveis = [];

                $template = $twig->load('home.html');

                $conteudo = $template->render($variaveis);

                echo $conteudo;
            } else {
                header('Location: ?pagina=admin');
                exit;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function reserva()
    {

        try {

            if (!isset($_SESSION['nome'])) {

                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);

                $variaveis = [];

                $template = $twig->load('reserva.html');

                $conteudo = $template->render($variaveis);

                echo $conteudo;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function retirada()
    {

        try {

            if (!isset($_SESSION['nome'])) {

                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);

                $variaveis = [];

                $template = $twig->load('retirada.html');

                $conteudo = $template->render($variaveis);

                echo $conteudo;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function login()
    {

        try {

            if (!isset($_SESSION['nome'])) {

                $loader = new \Twig\Loader\FilesystemLoader('app/view');
                $twig = new \Twig\Environment($loader);

                $variaveis = [];

                $template = $twig->load('login.html');

                $conteudo = $template->render($variaveis);

                echo $conteudo;
            } else {
                header('Location: ?pagina=admin');
                exit;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function logar()
    {

        try {
            $status = new Login;
            $status = $status->logar($_POST);

            if ($status) {
                header('Location: ?pagina=admin');
                exit;
            } else {
                self::index();
            }
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
