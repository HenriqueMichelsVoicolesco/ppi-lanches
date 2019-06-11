<?php

class UpdateController
{
    
    public function formAluno($params)
    {
        try {
            
            Session::verificaLogin();
            
            $dados = Read::selecionarTurmas();
            $dadosAluno = Read::selecionarAlunoPorId($params);
            
            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader);

            $template = $twig->load('adicionar.html');

            $variaveis = [];
            $variaveis['dados'] = $dados;
            $variaveis['dadosAluno'] = $dadosAluno;

            $conteudo = $template->render($variaveis);

            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function formServidor($params)
    {
        try {

            Session::verificaLogin();

            $dadosServidor = Read::selecionarServidorPorId($params);

            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader);

            $template = $twig->load('adicionar.html');

            $variaveis = [];
            $variaveis['dadosServidor'] = $dadosServidor;

            $conteudo = $template->render($variaveis);

            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function formTurma($params)
    {
        try {

            Session::verificaLogin();

            $dadosTurma = Read::selecionarTurmaPorId($params);
            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader);

            $template = $twig->load('adicionar.html');

            $variaveis = [];
            $variaveis['dadosTurma'] = $dadosTurma;
            $conteudo = $template->render($variaveis);

            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function salvarEdicaoAluno()
    {

        try {

            $status = Update::atualizarAluno($_POST);
            if ($status) {
                header('Location: ?pagina=admin&operacao=criado');
            } else {
                header('Location: ?pagina=admin&operacao=erro');
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function salvarEdicaoServidor()
    {

        try {

            $status = Update::atualizarServidor($_POST);
            if ($status) {
                header('Location: ?pagina=admin&operacao=criado');
            } else {
                header('Location: ?pagina=admin&operacao=erro');
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function salvarEdicaoTurma()
    {

        try {

            $status = Update::atualizarTurma($_POST);
            if ($status) {
                header('Location: ?pagina=admin&operacao=criado');
            } else {
                header('Location: ?pagina=admin&operacao=erro');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
