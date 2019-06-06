<?php

class Update
{

	public static function atualizarAluno($dadosAluno)
	{

		$con = Connection::getConn();

		$query = 'UPDATE
			alunos
		SET
			matricula = ?,
			nome = ?,
			codigo = ?,
			turma = ?
		WHERE
			matricula = ?';

		$stmt = $con->prepare($query);

		$stmt->bindParam('1', $dadosAluno['matricula']);
		$stmt->bindParam('2', $dadosAluno['nome']);
		$stmt->bindParam('3', $dadosAluno['rfid']);
		$stmt->bindParam('4', $dadosAluno['turma']);
		$stmt->bindParam('5', $dadosAluno['matricula']);

		$stmt->execute();

		$affectedRows = $stmt->rowCount();

		if ($affectedRows > 0) {
			echo "<script>alert('Registro atualizado com sucesso!')</script>";
		} 
	}

	public static function atualizarServidor($dadosServidor)
	{

		$con = Connection::getConn();

		$query = 'UPDATE
			servidores
		SET
			email = ?,
			nome = ?,
			senha = ?
		WHERE
			id_servidor = ?';

		$stmt = $con->prepare($query);

		$stmt->bindParam('1', $dadosServidor['email']);
		$stmt->bindParam('2', $dadosServidor['nome']);
		$stmt->bindParam('3', $dadosServidor['senha']);
		$stmt->bindParam('4', $dadosServidor['senha']);

		$stmt->execute();

		$affectedRows = $stmt->rowCount();

		if ($affectedRows > 0) {
			echo "<script>alert('Registro atualizado com sucesso!')</script>";
		} 
	}

	public static function atualizarTurma($dadosTurma)
	{

		$con = Connection::getConn();

		$checkbox = implode(',', $dadosTurma['diasLanche']);

		$query = 'UPDATE
			turmas
		SET
			curso = ?,
			semestre = ?,
			modalidade = ?,
			dias_lanche = ?
		WHERE
			id_turma = ?';
		
		$stmt = $con->prepare($query);

		$stmt->bindParam('1', $dadosTurma['curso']);
		$stmt->bindParam('2', $dadosTurma['semestre']);
		$stmt->bindParam('3', $dadosTurma['modalidade']);
		$stmt->bindParam('4', $checkbox);
		$stmt->bindParam('5', $dadosTurma['id_turma']);

		$stmt->execute();

		$affectedRows = $stmt->rowCount();

		if ($affectedRows > 0) {
			echo "<script>alert('Registro atualizado com sucesso!')</script>";
		} 

	}
}
