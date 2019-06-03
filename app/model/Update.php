<?php

class Update
{

	public static function atualizarAluno($params, $matricula, $nome, $rfid, $turma)
	{
		var_dump($matricula, $nome, $rfid, $turma);
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

		$stmt->bindParam('1', $matricula);
		$stmt->bindParam('2', $nome);
		$stmt->bindParam('3', $rfid);
		$stmt->bindParam('4', $turma);
		$stmt->bindParam('5', $params);

		$stmt->execute();

		$affectedRows = $stmt->rowCount();

		if ($affectedRows > 0) {
			echo "<script>alert('Registro atualizado com sucesso!')</script>";
		} 
	}

	public static function atualizarServidor($id, $email, $nome, $senha)
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

		$stmt->bindParam('1', $email);
		$stmt->bindParam('2', $nome);
		$stmt->bindParam('3', $senha);
		$stmt->bindParam('4', $id);

		$stmt->execute();

		$affectedRows = $stmt->rowCount();

		if ($affectedRows > 0) {
			echo "<script>alert('Registro atualizado com sucesso!')</script>";
		} 
	}

	public static function atualizarTurma($id, $curso, $semestre, $modalidade, $diasLanche)
	{

		$con = Connection::getConn();

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

		$stmt->bindParam('1', $curso);
		$stmt->bindParam('2', $semestre);
		$stmt->bindParam('3', $modalidade);
		$stmt->bindParam('4', $diasLanche);
		$stmt->bindParam('5', $id);

		$stmt->execute();

		$affectedRows = $stmt->rowCount();

		if ($affectedRows > 0) {
			echo "<script>alert('Registro atualizado com sucesso!')</script>";
		} 

	}
}
