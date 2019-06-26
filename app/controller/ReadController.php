<?php

class ReadController
{

    public function index()
    {

        try {

            Session::verificaLogin();

            $dados = new Read;
            $dados = $dados->selecionarRegistros();

            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader);

            $variaveis = [];

            $template = $twig->load('registros.html');

            $variaveis['dados'] = $dados;

            $conteudo = $template->render($variaveis);

            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function turmas(){

        try {

            Session::verificaLogin();

            $dados = new Read;
            $dados = $dados->selecionarTurmas();

            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader);

            $variaveis = [];

            $template = $twig->load('turmas.html');

            $variaveis['dados'] = $dados;
            $variaveis['operacao'] = isset($_GET['operacao']) ? $_GET['operacao'] : null;

            $conteudo = $template->render($variaveis);

            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function usuarios(){

        try {
            Session::verificaLogin();

            $dados = new Read;
            $dadosAlunos = $dados->selecionarAlunos();
            $dadosServidores = $dados->selecionarServidores();
            $dadosTurmas = $dados->selecionarTurmas();

            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader);

            $variaveis = [];

            $template = $twig->load('usuarios.html');

            $variaveis['dadosAluno'] = $dadosAlunos;
            $variaveis['dadosServidor'] = $dadosServidores;
            $variaveis['dadosTurma'] = $dadosTurmas;
            $variaveis['operacao'] = isset($_GET['operacao']) ? $_GET['operacao'] : null;

            $conteudo = $template->render($variaveis);

            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function numRegistros(){
        
        try {

            $numRegistros = new Read;

            $numRegistros = $numRegistros->numeroRegistros();

            echo json_encode($numRegistros);
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } 

    public function respostaReserva(){
        try {

            $key = strlen('reserva');

            SharedMemory::read($key);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function respostaRetirada(){
        try {

            $key = strlen('retirada');

            SharedMemory::read($key);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
