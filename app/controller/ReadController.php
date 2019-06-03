<?php

class ReadController
{

    public function index()
    {

        try {

            $dados = Read::selecionarRegistros();

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

            $dados = Read::selecionarTurmas();

            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader);

            $variaveis = [];

            $template = $twig->load('turmas.html');

            $variaveis['dados'] = $dados;

            $conteudo = $template->render($variaveis);

            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function usuarios(){

        try {

            $dadosAlunos = Read::selecionarAlunos();
            $dadosServidores = Read::selecionarServidores();
            $dadosTurmas = Read::selecionarTurmas();

            $loader = new \Twig\Loader\FilesystemLoader('app/view');
            $twig = new \Twig\Environment($loader);

            $variaveis = [];

            $template = $twig->load('usuarios.html');

            $variaveis['dadosAluno'] = $dadosAlunos;
            $variaveis['dadosServidor'] = $dadosServidores;
            $variaveis['dadosTurma'] = $dadosTurmas;

            $conteudo = $template->render($variaveis);

            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
