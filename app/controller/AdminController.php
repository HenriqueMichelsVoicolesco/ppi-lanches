<?php

class AdminController
{

    public function index()
    {

        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        try {
            $dados = Login::logar($email, $senha);

            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader);

            $variaveis = [];

            $template = $twig->load('admin.html');
            
            $variaveis['dados'] = $dados;

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

        $loader = new \Twig\Loader\FilesystemLoader('app/view');
        $twig = new \Twig\Environment($loader);

        $template = $twig->load('home.html');

        $variaveis = [];

        $conteudo = $template->render($variaveis);

        echo $conteudo;
    }
}
