<?php

class UpdateController
{

    public function aluno($params)
    {

        $matricula = $_POST['matricula'];
		$nome = $_POST['nome_aluno'];
		$rfid = $_POST['rfid'];
		$turma = $_POST['turma'];

        try {

            Update::atualizarAluno($params, $matricula, $nome, $rfid, $turma);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function servidor($params)
    {

        $email = $_POST['email'];
		$nome = $_POST['nome_servidor'];
		$senha = $_POST['senha'];

        try {

            Update::atualizarServidor($params, $email, $nome, $senha);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function turma($params)
    {

        $curso = $_POST['curso'];
		$semestre = $_POST['semestre'];
        $modalidade = $_POST['modalidade'];
        $diasLanche = implode(",", $_POST['diasLanche']);

        try {

            Update::atualizarTurma($params, $curso, $semestre, $modalidade, $diasLanche);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
