<?php

class UpdateController
{

    public function formAluno($params)
    {
        try {

            Session::verificaLogin();

            $dados = Read::selecionarAlunoPorId($params);

            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader);

            $template = $twig->load('adicionar.html');

            $variaveis = [];
            $variaveis['dados'] = $dados;

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

            $dados = Read::selecionarServidorPorId($params);

            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader);

            $template = $twig->load('adicionar.html');

            $variaveis = [];
            $variaveis['dados'] = $dados;

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
            $dados = Read::selecionarTurmas();

            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader);

            $template = $twig->load('adicionar.html');

            $variaveis = [];
            $variaveis['dadosTurma'] = $dadosTurma;
            $variaveis['dados'] = $dados;

            $conteudo = $template->render($variaveis);

            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }


    public function salvarEdicaoAluno()
    {

        try {

            Update::atualizarAluno($_POST);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function salvarEdicaoServidor()
    {

        try {

            Update::atualizarServidor($_POST);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function salvarEdicaoTurma()
    {

        try {

            Update::atualizarTurma($_POST);
            header('Location: ?pagina=admin&operacao=atualizado');
            exit;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
