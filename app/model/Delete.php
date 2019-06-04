<?php

class Delete
{

	public static function deletarAluno($matricula)
	{

		$con = Connection::getConn();

		$query = 'DELETE
		FROM
			alunos
		WHERE
			matricula = ?
		';

		$stmt = $con->prepare($query);

		$stmt->bindParam('1', $matricula);

		$stmt->execute();

		$affectedRows = $stmt->rowCount();

		if ($affectedRows > 0) {
			return true;
		} 
	}

	public static function deletarServidor($id)
	{

		$con = Connection::getConn();

		$query = 'DELETE
		FROM
			servidores
		WHERE
			id_servidor = ?
		';

		$stmt = $con->prepare($query);

		$stmt->bindParam('1', $id);

		$stmt->execute();

		$affectedRows = $stmt->rowCount();

		if ($affectedRows > 0) {
			return true;
		} 
	}

	public static function deletarTurma($id)
	{

		$con = Connection::getConn();

		$query = 'DELETE
		FROM
			turmas
		WHERE
			id_turma = ?
		';

		$stmt = $con->prepare($query);

		$stmt->bindParam('1', $id);

		$stmt->execute();

		$affectedRows = $stmt->rowCount();

		if ($affectedRows > 0) {
			return true;
		} 
	}
}
