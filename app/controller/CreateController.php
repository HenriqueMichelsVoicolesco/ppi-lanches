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
        } catch (Error $e) {
            header('Location: ?pagina=error&id='. $e->getCode());
			exit;
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
        } catch (Error $e) {
            header('Location: ?pagina=error&id='. $e->getCode());
			exit;
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
        } catch (Error $e) {
            header('Location: ?pagina=error&id='. $e->getCode());
			exit;
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
        } catch (Error $e) {
            header('Location: ?pagina=error&id='. $e->getCode());
			exit;
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

    public function relatorio()
    {

        try {
            $relatorio = new Read;

            $relatorio = $relatorio->gerarRelatorio($_POST);
            
            $nome_arquivo = "relatorio_lanche_{$_POST['relatorio_de']}_{$_POST['relatorio_ate']}";    
            
            Relatorio::gerarTabela($relatorio, $nome_arquivo);
        } catch (Error $e) {
            header('Location: ?pagina=error&id='. $e->getCode());
			exit;
        }
    }
}
