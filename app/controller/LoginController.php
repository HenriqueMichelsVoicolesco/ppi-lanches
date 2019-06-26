<?php

class LoginController
{

    public function index()
    {
        
        try {
            
                $dados = new Login;
                $dados = $dados->logar($_POST);
                
                if ($dados && !$_SESSION['nome']) {
                    self::login();
                }
                
            } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function login(){
        $loader = new \Twig\Loader\FilesystemLoader('app/view');
        $twig = new \Twig\Environment($loader);

        $variaveis = [];

        $template = $twig->load('admin.html');
        
        $variaveis['dados'] = $_SESSION['nome'];

        $conteudo = $template->render($variaveis);

        echo $conteudo;
    }
}
