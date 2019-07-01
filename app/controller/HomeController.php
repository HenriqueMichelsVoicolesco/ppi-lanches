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
        } catch (Error $e) {
            header('Location: ?pagina=error&id='. $e->getCode());
			exit;
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
            } else {
                header('Location: ?pagina=admin');
                exit;
            }
        } catch (Error $e) {
            header('Location: ?pagina=error&id='. $e->getCode());
			exit;
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
            } else {
                header('Location: ?pagina=admin');
                exit;
            }
        } catch (Error $e) {
            header('Location: ?pagina=error&id='. $e->getCode());
			exit;
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

                $variaveis['operacao'] = $_GET['operacao'] ?? null;
                $conteudo = $template->render($variaveis);

                echo $conteudo;
            } else {
                header('Location: ?pagina=admin');
                exit;
            }
        } catch (Error $e) {
            header('Location: ?pagina=error&id='. $e->getCode());
			exit;
        }
    }

    public function logar()
    {

        try {
            $status = new Login;
            $status = $status->logar($_POST);
            var_dump($status);
            if ($status === 'erro') {
                header("Location: ?pagina=home&metodo=login&operacao=$status");
                exit;
            } else {
                header('Location: ?pagina=admin');
                exit;
            }
        } catch (Error $e) {
            header('Location: ?pagina=error&id='. $e->getCode());
			exit;
        }
    }
}
