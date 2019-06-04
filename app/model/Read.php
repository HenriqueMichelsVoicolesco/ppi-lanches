<?php

class Read
{

	public static function numeroRegistros()
	{ 
		$con = Connection::getConn();

		$query = 'SELECT 
			COUNT(DISTINCT matricula_aluno)
		AS
			num_registros
		FROM
			registros;';

		$stmt = $con->prepare($query);

		$stmt->execute();

		$resultado = [];

		while ($row = $stmt->fetchObject('Read')) {
			$resultado[] = $row;
		}

		return $resultado;
	}

	public static function selecionarRegistros()
	{

		$con = Connection::getConn();

		$query = 'SELECT
			registros.id_registro,
			registros.codigo_aluno,
			registros.matricula_aluno,
			alunos.nome,
			turmas.curso,
			registros.timestamp_registro
		FROM
			registros
		INNER JOIN alunos ON(matricula_aluno = matricula)
		INNER JOIN turmas ON(turma_aluno = id_turma);';

		$stmt = $con->prepare($query);

		$stmt->execute();

		$resultado = [];

		while ($row = $stmt->fetchObject('Read')) {
			$resultado[] = $row;
		}

		return $resultado;
	}

	public static function selecionarTurmas()
	{

		$con = Connection::getConn();

		$query = 'SELECT *
		FROM
			turmas;';

		$stmt = $con->prepare($query);

		$stmt->execute();

		$resultado = [];

		while ($row = $stmt->fetchObject('Read')) {
			$resultado[] = $row;
		}

		return $resultado;
	}

	public static function selecionarAlunos()
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
		INNER JOIN turmas ON(turma = id_turma)';

		$stmt = $con->prepare($query);

		$stmt->execute();

		$resultado = [];

		while ($row = $stmt->fetchObject('Read')) {
			$resultado[] = $row;
		}

		return $resultado;
	}

	public static function selecionarServidores()
	{

		$con = Connection::getConn();

		$query = 'SELECT *
		FROM
			servidores;';

		$stmt = $con->prepare($query);

		$stmt->execute();

		$resultado = [];

		while ($row = $stmt->fetchObject('Read')) {
			$resultado[] = $row;
		}

		return $resultado;
	}
}
