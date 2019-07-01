<?php

class ReadController
{

    public function registros()
    {

        try {

            Session::verificaLogin();

            $dados = new Read;
            $dadosTurmas = $dados->selecionarTurmas();
            $dadosRegistros = $dados->selecionarRegistros();
            $dadosIntervaloRegistros = $dados->selecionarIntervaloRegistros();

            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader);

            $variaveis = [];

            $template = $twig->load('registros.html');

            $variaveis['dadosTurmas'] = $dadosTurmas;
            $variaveis['dadosRegistros'] = $dadosRegistros;
            $variaveis['dadosIntervaloRegistros'] = $dadosIntervaloRegistros;

            $conteudo = $template->render($variaveis);

            echo $conteudo;
        } catch (Error $e) {
            header('Location: ?pagina=error&id='. $e->getCode());
			exit;
        }
    }

    public function turmas()
    {

        try {

            Session::verificaLogin();

            $dados = new Read;
            $dados = $dados->selecionarTurmas();

            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader);

            $variaveis = [];

            $template = $twig->load('turmas.html');

            $variaveis['dados'] = $dados;
            $variaveis['operacao'] = $_GET['operacao'] ?? null;

            $conteudo = $template->render($variaveis);

            echo $conteudo;
        } catch (Error $e) {
            header('Location: ?pagina=error&id='. $e->getCode());
			exit;
        }
    }

    public function usuarios()
    {

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
            $variaveis['operacao'] = $_GET['operacao'] ?? null;

            $conteudo = $template->render($variaveis);

            echo $conteudo;
        } catch (Error $e) {
            header('Location: ?pagina=error&id='. $e->getCode());
			exit;
        }
    }

    public function numRegistros()
    {

        try {

            $numRegistros = new Read;

            $numRegistros = $numRegistros->numeroRegistros();

            echo json_encode($numRegistros);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function respostaReserva()
    {
        try {

            //cria o nome da memoria como o tamanho da palavra
            $key = strlen('reserva');
            //chama a função passando a mensagem e a chave
            SharedMemory::read($key);
        } catch (Error $e) {
            header('Location: ?pagina=error&id='. $e->getCode());
			exit;
        }
    }

    public function respostaRetirada()
    {
        try {

            //cria o nome da memoria como o tamanho da palavra
            $key = strlen('retirada');
            //chama a função passando a mensagem e a chave
            SharedMemory::read($key);
        } catch (Error $e) {
            header('Location: ?pagina=error&id='. $e->getCode());
			exit;
        }
    }
}
