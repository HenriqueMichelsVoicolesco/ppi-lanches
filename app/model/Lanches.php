<?php
date_default_timezone_set('America/Sao_Paulo');

class Lanches
{

	public static function selecionaRegistos()
	{

		$con = Connection::getConn();

		$query = 'SELECT
		    registros.id_registro,
		    registros.codigo_aluno,
		    registros.matricula_aluno,
		    alunos.nome,
		    turmas.curso,
		    registros.timestamp
	    FROM
		    registros
	    INNER JOIN alunos ON
		    (matricula_aluno = matricula)
	    INNER JOIN turmas ON
		    (turma_aluno = turma);';

		$stmt = $con->prepare($query);
		$stmt->execute();

		$result = [];

		while ($row = $stmt->fetchObject('Lanches')) {
			$result[] = $row;
		}

		// if (!$result) {
		// 	throw new Exception('Não foi encontrado nenhum registro no banco');
		// }

		return $result;
	}

	public static function numInserts()
	{
		$con = Connection::getConn();

		$rfid = $_POST['rfid'] ?? '8a45as54sf8sdf1';

		$query = 'SELECT count(*) FROM registros WHERE codigo_aluno = ? AND DATE(timestamp) = ?';

		$timestamp = date('Y') . '-' . date('m') . '-' . date('d');

		$stmt = $con->prepare($query);
		$stmt->bindParam('1', $rfid);
		$stmt->bindParam('2', $timestamp);
		$stmt->execute();

		$userReads = $stmt->fetchColumn();

		return $userReads;
	}

	public static function insert()
	{

		$con = Connection::getConn();

		$userReads = numInserts();

		$dia = date('w');
		$nome_dias = [
			'%Domingo%', '%Segunda-Feira%',
			'%Terça-Feira%', '%Quarta-Feira%', '%Quinta-Feira%',
			'%Sexta-Feira%', '%Sábado%'
		];

		if ($userReads > 2) {
			echo 'Limite excedido!';
		} else {
			$query = ('
		INSERT INTO registros(
			codigo_aluno,
			matricula_aluno,
			turma_aluno
			)
		SELECT
		alunos.codigo,
		alunos.matricula,
			alunos.turma
			FROM
			alunos
		INNER JOIN turmas ON
		(turma = id_turma)
		WHERE
		alunos.codigo = ? AND turmas.horarios LIKE ?
		');

			$stmt = $con->prepare($query);
			$stmt->bindParam('1', $rfid);
			$stmt->bindParam('2', $nome_dias[$dia]);
			$stmt->execute();

			$selectedRows = $stmt->rowCount();

			// if ($selectedRows > 0) {
			// 	echo 'Inserido com sucesso!!!';
			// } else {
			// 	echo 'Erro ao inserir!!!';
			// }
		}
	}
}
