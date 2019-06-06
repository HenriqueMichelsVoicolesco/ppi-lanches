<?php

class Create
{

	public static function cadastrarAluno($dadosAluno)
	{
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

		$stmt->bindParam('1', $dadosAluno['matricula']);
		$stmt->bindParam('2', $dadosAluno['nome']);
		$stmt->bindParam('3', $dadosAluno['rfid']);
		$stmt->bindParam('4', $dadosAluno['turma']);

		$stmt->execute();

		$affectedRows = $stmt->rowCount();

		if ($affectedRows > 0) {
			return true;
		} 
	}

	public static function cadastrarServidor($dadosServidor)
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

		$stmt->bindParam('1', $dadosServidor['email']);
		$stmt->bindParam('2', $dadosServidor['nome']);
		$stmt->bindParam('3', $dadosServidor['senha']);

		$stmt->execute();

		$affectedRows = $stmt->rowCount();

		if ($affectedRows > 0) {
			return true;
		} 
	}

	public static function cadastrarTurma($dadosTurma)
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

		$stmt->bindParam('1', $dadosTurma['curso']);
		$stmt->bindParam('2', $dadosTurma['semestre']);
		$stmt->bindParam('3', $dadosTurma['modalidade']);
		$stmt->bindParam('4', $dadosTurma['diasLanche']);
		$stmt->execute();

		$affectedRows = $stmt->rowCount();

		if ($affectedRows > 0) {
			return true;
		} 

	}
}
