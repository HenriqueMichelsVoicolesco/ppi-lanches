<?php

class AdminController
{

    public function index()
    {

        try {

            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader);

            $variaveis = [];

            if (isset($_SESSION['nome'])) {
                $template = $twig->load('admin.html');
                $variaveis['nome'] = unserialize($_SESSION['nome']);
            } else {
                $template = $twig->load('login.html');

                $variaveis['dados'] = 'erro';
            }

            $conteudo = $template->render($variaveis);

            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        header('Location: ?pagina=home');
        exit;
    }
}
