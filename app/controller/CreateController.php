<?php

class CreateController
{

    public function index()
    {
        try {

            Session::verificaLogin();

            $dados = new Read;
            $dados = $dados->selecionarTurmas();

            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader);

            $template = $twig->load('adicionar.html');

            $variaveis = [];
            $variaveis['dados'] = $dados;
            $variaveis['operacao'] = isset($_GET['operacao']) ? $_GET['operacao'] : null;

            $conteudo = $template->render($variaveis);

            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function aluno()
    {

        try {

            Session::verificaLogin();

            $status = new Create;
            $status = $status->cadastrarAluno($_POST);

            header("Location: ?pagina=create&operacao=$status");
            exit;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function servidor()
    {

        try {

            Session::verificaLogin();

            $status = new Create;
            $status = $status->cadastrarServidor($_POST);

            header("Location: ?pagina=create&operacao=$status");
            exit;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function turma()
    {

        try {

            Session::verificaLogin();

            $status = new Create;
            $status = $status->cadastrarTurma($_POST);

            header("Location: ?pagina=create&operacao=$status");
            exit;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function reservaRfid($params)
    {
        
        try {

            $registro = new Create;

            $registro->reservarLancheRfid($params);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function reservaMatricula($params)
    {

        try {

            $registro = new Create;

            $registro->reservarLancheMatricula($params);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function retiradaRfid($params)
    {
        
        try {

            $registro = new Create;

            $registro->retirarLancheRfid($params);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function retiradaMatricula($params)
    {

        try {

            $registro = new Create;

            $registro->retirarLancheMatricula($params);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
