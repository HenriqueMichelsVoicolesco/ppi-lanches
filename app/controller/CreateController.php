<?php

class CreateController
{

    public function index()
    {
        try {

            Session::verificaLogin();

            $dados = Read::selecionarTurmas();

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

    public function aluno($params)
    {

        try {

            Session::verificaLogin();

            $matricula = $_POST['matricula'];
            $nome = $_POST['nome_aluno'];
            $rfid = $_POST['rfid'];
            $turma = $_POST['turma'];

            $status = Create::cadastrarAluno($params, $matricula, $nome, $rfid, $turma);

            if ($status) {
                header('Location: ?pagina=admin&operacao=criado');
            } else {
                header('Location: ?pagina=admin&operacao=erro');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function servidor()
    {

        try {

            Session::verificaLogin();

            $email = $_POST['email'];
            $nome = $_POST['nome_servidor'];
            $senha = $_POST['senha'];

            $status = Create::cadastrarServidor($email, $nome, $senha);

            if ($status) {
                header('Location: ?pagina=admin&operacao=criado');
            } else {
                header('Location: ?pagina=admin&operacao=erro');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function turma()
    {

        try {

            Session::verificaLogin();

            $curso = $_POST['curso'];
            $semestre = $_POST['semestre'];
            $modalidade = $_POST['modalidade'];
            $diasLanche = implode(",", $_POST['diasLanche']);

            $status = Create::cadastrarTurma($curso, $semestre, $modalidade, $diasLanche);

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
