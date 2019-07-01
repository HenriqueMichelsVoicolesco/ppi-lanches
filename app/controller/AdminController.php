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
                header('Location: ?pagina=home&metodo=login');
                exit;
            }

            $conteudo = $template->render($variaveis);

            echo $conteudo;
        } catch (Error $e) {
            header('Location: ?pagina=error&id='. $e->getCode());
			exit;
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
