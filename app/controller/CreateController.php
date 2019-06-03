<?php

class CreateController
{

    public function index()
    {

        $dados = Read::selecionarTurmas();
        
        $loader = new \Twig\Loader\FilesystemLoader('app/view');
        $twig = new \Twig\Environment($loader);

        $template = $twig->load('adicionar.html');

        $variaveis = [];
        $variaveis['dados'] = $dados;

        $conteudo = $template->render($variaveis);

        echo $conteudo;
    }

    public function aluno($params)
    {

        $matricula = $_POST['matricula'];
		$nome = $_POST['nome_aluno'];
		$rfid = $_POST['rfid'];
		$turma = $_POST['turma'];

        try {

            Create::cadastrarAluno($params, $matricula, $nome, $rfid, $turma);

            // $loader = new \Twig\Loader\FilesystemLoader('app/view');
            // $twig = new \Twig\Environment($loader);

            // $template = $twig->load('admin.html');

            // $variaveis = [];
            // $variaveis['nomes'] = $resultado;

            // $conteudo = $template->render($variaveis);

            // echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function servidor()
    {

        $email = $_POST['email'];
		$nome = $_POST['nome_servidor'];
		$senha = $_POST['senha'];

        Create::cadastrarServidor($email, $nome, $senha);

    }

    public function turma()
    {

        $curso = $_POST['curso'];
		$semestre = $_POST['semestre'];
        $modalidade = $_POST['modalidade'];
        $diasLanche = implode(",", $_POST['diasLanche']);

        Create::cadastrarTurma($curso, $semestre, $modalidade, $diasLanche);
        
    }
}
