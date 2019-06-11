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

    public function aluno()
    {

        try {

            Session::verificaLogin();

            $status = Create::cadastrarAluno($_POST);

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

            $status = Create::cadastrarServidor($_POST);

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

            $status = Create::cadastrarTurma($_POST);

            if ($status) {
                header('Location: ?pagina=admin&operacao=criado');
            } else {
                header('Location: ?pagina=admin&operacao=erro');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function registro($params)
    {

        try {

            $registro = new Create;

            $registro->cadastrarRegistro($params);
            // Create::cadastrarRegistro($params);

            // if ($status) {
            //     header('Location: ?pagina=admin&operacao=criado');
            // } else {
            //     header('Location: ?pagina=admin&operacao=erro');
            // }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
