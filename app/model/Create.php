<?php

class Create
{

	public static function cadastrarAluno($matricula, $nome, $rfid, $turma)
	{
		var_dump($matricula, $nome, $rfid, $turma);
		$con = Connection::getConn();

		$query = 'INSERT INTO alunos (
			matricula, 
			nome, 
			codigo, 
			turma
		) VALUES (
			?, ?, ?, ?
		)';

		$stmt = $con->prepare($query);

		$stmt->bindParam('1', $matricula);
		$stmt->bindParam('2', $nome);
		$stmt->bindParam('3', $rfid);
		$stmt->bindParam('4', $turma);

		$stmt->execute();

		$affectedRows = $stmt->rowCount();

		if ($affectedRows > 0) {
			echo "<script>alert('Cadastro efetuado com sucesso!')</script>";
		} 
	}

	public static function cadastrarServidor($email, $nome, $senha)
	{

		$con = Connection::getConn();

		$query = 'INSERT INTO servidores (
			email, 
			nome, 
			senha
		) VALUES (
			?, ?, ?
		)';

		$stmt = $con->prepare($query);

		$stmt->bindParam('1', $email);
		$stmt->bindParam('2', $nome);
		$stmt->bindParam('3', $senha);

		$stmt->execute();

		$affectedRows = $stmt->rowCount();

		if ($affectedRows > 0) {
			echo "<script>alert('Cadastro efetuado com sucesso!')</script>";
		} 
	}

	public static function cadastrarTurma($curso, $semestre, $modalidade, $diasLanche)
	{

		$con = Connection::getConn();

		$query = 'INSERT INTO turmas (
			curso, 
			semestre, 
			modalidade,
			dias_lanche
		) VALUES (
			?, ?, ?, ?
		)';
		
		$stmt = $con->prepare($query);

		$stmt->bindParam('1', $curso);
		$stmt->bindParam('2', $semestre);
		$stmt->bindParam('3', $modalidade);
		$stmt->bindParam('4', $diasLanche);
		$stmt->execute();

		$affectedRows = $stmt->rowCount();

		if ($affectedRows > 0) {
			echo "<script>alert('Cadastro efetuado com sucesso!')</script>";
		} 

	}
}
