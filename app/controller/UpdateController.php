<?php

class UpdateController
{
    
    public function formAluno($params)
    {
        try {
            
            Session::verificaLogin();
            
            $dados = new Read;
            $dadosTurma = $dados->selecionarTurmas();
            $dadosAluno = $dados->selecionarAlunoPorId($params);
            
            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader);

            $template = $twig->load('adicionar.html');

            $variaveis = [];
            $variaveis['dados'] = $dadosTurma;
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

            $dados = new Read;
            $dadosServidor = $dados->selecionarServidorPorId($params);

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

            $dados = new Read;
            $dadosTurma = $dados->selecionarTurmaPorId($params);

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

            $status = new Update;

            $status = $status->atualizarAluno($_POST);

            header("Location: ?pagina=read&metodo=usuarios&operacao=$status");
            exit;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function salvarEdicaoServidor()
    {

        try {

            $status = new Update;

            $status = $status->atualizarServidor($_POST);

            header("Location: ?pagina=read&metodo=usuarios&operacao=$status");
            exit;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function salvarEdicaoTurma()
    {

        try {

            $status = new Update;

            $status = $status->atualizarTurma($_POST);
           
            header("Location: ?pagina=read&metodo=turmas&operacao=$status");
            exit;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
