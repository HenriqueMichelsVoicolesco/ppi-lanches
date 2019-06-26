<?php

class Read
{

	public function numeroRegistros()
	{ 
		$con = Connection::getConn();

		$data_atual = new DateTime();

		$query = 'SELECT 
			COUNT(matricula_aluno)
		AS
			num_registros
		FROM
			registros
		WHERE
			DATE(timestamp_reserva) = ?;';

		$stmt = $con->prepare($query);
		$stmt->bindValue('1', $data_atual->format('Y-m-d'));

		$stmt->execute();

		$resultado = [];

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		return $row;
	}

	public function selecionarRegistros()
	{

		$con = Connection::getConn();

		$data_atual = new DateTime();

		$query = 'SELECT
			registros.id_registro,
			registros.codigo_aluno,
			registros.matricula_aluno,
			alunos.nome,
			turmas.curso,
			registros.timestamp_reserva,
			registros.timestamp_retirada
		FROM
			registros
		INNER JOIN alunos ON(matricula_aluno = matricula)
		INNER JOIN turmas ON(turma_aluno = id_turma)
		WHERE
			DATE(timestamp_reserva) = ?;';

		$stmt = $con->prepare($query);

		$stmt->bindValue('1', $data_atual->format('Y-m-d'));

		$stmt->execute();

		$resultado = [];

		while ($row = $stmt->fetchObject('Read')) {
			$resultado[] = $row;
		}

		return $resultado;
	}

	public function selecionarTurmas()
	{

		$con = Connection::getConn();

		$query = 'SELECT *
		FROM
			turmas
		ORDER BY
    		curso ASC;';

		$stmt = $con->prepare($query);

		$stmt->execute();

		$resultado = [];

		while ($row = $stmt->fetchObject('Read')) {
			$resultado[] = $row;
		}

		return $resultado;
	}

	public function selecionarAlunos()
	{

		$con = Connection::getConn();

		$query = 'SELECT
			alunos.matricula,
			alunos.nome,
			alunos.codigo,
			alunos.turma,
			turmas.curso
		FROM
			alunos
		INNER JOIN turmas ON(turma = id_turma)
		ORDER BY
    		nome ASC;';

		$stmt = $con->prepare($query);

		$stmt->execute();

		$resultado = [];

		while ($row = $stmt->fetchObject('Read')) {
			$resultado[] = $row;
		}

		return $resultado;
	}

	public function selecionarServidores()
	{

		$con = Connection::getConn();

		$query = 'SELECT *
		FROM
			servidores
		ORDER BY
    		nome ASC;';

		$stmt = $con->prepare($query);

		$stmt->execute();

		$resultado = [];

		while ($row = $stmt->fetchObject('Read')) {
			$resultado[] = $row;
		}

		return $resultado;
	}

	public static function selecionarTurmaPorId($params)
	{

		$con = Connection::getConn();

		$query = 'SELECT *
		FROM
			turmas
		WHERE 
			id_turma = ?;';

		$stmt = $con->prepare($query);
		$stmt->bindValue('1', $params);
		$stmt->execute();

		$resultado = [];

		while ($row = $stmt->fetchObject('Read')) {
			$resultado[] = $row;
		}

		return $resultado;
	}

	public function selecionarAlunoPorId($params)
	{

		$con = Connection::getConn();

		$query = 'SELECT *
		FROM
			alunos
		WHERE 
			matricula = ?;';

		$stmt = $con->prepare($query);
		$stmt->bindValue('1', $params);
		$stmt->execute();

		$resultado = [];

		while ($row = $stmt->fetchObject('Read')) {
			$resultado[] = $row;
		}

		return $resultado;
	}

	public function selecionarServidorPorId($params)
	{

		$con = Connection::getConn();

		$query = 'SELECT *
		FROM
			servidores
		WHERE 
			id_servidor = ?;';

		$stmt = $con->prepare($query);
		$stmt->bindValue('1', $params);
		$stmt->execute();

		$resultado = [];

		while ($row = $stmt->fetchObject('Read')) {
			$resultado[] = $row;
		}

		return $resultado;
	}

}
