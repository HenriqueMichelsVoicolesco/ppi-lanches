<?php

class HomeController
{

    public function index()
    {

        try {

            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader);
            
            $variaveis = [];

            $template = $twig->load('home.html');

            $conteudo = $template->render($variaveis);

            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
