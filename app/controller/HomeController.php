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
}
