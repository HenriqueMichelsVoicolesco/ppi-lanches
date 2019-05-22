<?php

class HomeController
{

    public function index()
    {

        try {

            $todosRegistros = Lanches::selecionaRegistos();

            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader);

            if ($todosRegistros != null) {
                $template = $twig->load('tabelas.html');

                $parametros = [];
                $parametros['post'] = $todosRegistros;

                $conteudo = $template->render($parametros);
            } else {
                $template = $twig->load('semRegistros.html');

                $conteudo = $template->render();
            }

            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
