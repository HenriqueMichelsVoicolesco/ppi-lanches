<?php

class Read
{

	public function numeroRegistros()
	{ 
		$con = Connection::getConn();

		$data_atual = new DateTime();

		$query = 'SELECT 
			turmas.curso,
			turmas.semestre,
			turmas.modalidade,
			COUNT(registros.matricula_aluno)
		AS
			num_registros
		FROM
			registros
		INNER JOIN turmas ON(turma_aluno = id_turma)
		WHERE
			DATE(timestamp_reserva) = ?
		GROUP BY turmas.id_turma
		ORDER BY turmas.curso ASC, turmas.semestre ASC;';

		$stmt = $con->prepare($query);
		$stmt->bindValue('1', $data_atual->format('Y-m-d'));

		$stmt->execute();

		$resultado = [];

		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$resultado[] = $row;
		}

		return $resultado;
	}

	public function selecionarRegistros()
	{

		$con = Connection::getConn();

		$data_atual = new DateTime();

		$query = 'SELECT
			registros.id_registro,
			registros.codigo_aluno,
			registros.matricula_aluno,
			registros.turma_aluno,
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

	public function selecionarIntervaloRegistros()
	{

		$con = Connection::getConn();

		$query = 'SELECT
			MIN(DATE(timestamp_reserva)) AS menor_data,
			MAX(DATE(timestamp_retirada)) AS maior_data
		FROM
			registros;';

		$stmt = $con->prepare($query);

		$stmt->execute();
		
		$resultado = $stmt->fetchObject('Read');

		return $resultado;
	}

	public function selecionarTurmas()
	{

		$con = Connection::getConn();

		$query = 'SELECT *
		FROM
			turmas
		ORDER BY
    		curso ASC, semestre ASC;';

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

	public function gerarRelatorio($params)
	{
		$con = Connection::getConn();

		$relatorio_de = new DateTime($params['relatorio_de']);
		$relatorio_ate = new DateTime($params['relatorio_ate']);

		if ($relatorio_de < $relatorio_de || $relatorio_de == $relatorio_de) {
			$relatorio_de = $relatorio_de;
			$relatorio_ate = $relatorio_ate;
		} else if ($relatorio_de > $relatorio_de) {
			$relatorio_de = new DateTime($params['relatorio_ate']);
			$relatorio_ate = new DateTime($params['relatorio_de']);
		}

		$query = 'SELECT
			registros.id_registro AS Id,
			registros.codigo_aluno AS "Código RFID",
			registros.matricula_aluno AS Matrícula,
			alunos.nome AS Nome,
			turmas.curso AS Curso,
			registros.timestamp_reserva AS Reserva,
			registros.timestamp_retirada AS Retirada
		FROM
			registros
		INNER JOIN alunos ON(matricula_aluno = matricula)
		INNER JOIN turmas ON(turma_aluno = id_turma)
		WHERE
			DATE(timestamp_reserva) >= ? AND DATE(timestamp_retirada) <= ?';

		$stmt = $con->prepare($query);
		$stmt->bindValue('1', $relatorio_de->format('Y-m-d'));
		$stmt->bindValue('2', $relatorio_ate->format('Y-m-d'));
		$stmt->execute();

		$resultado = [];

		while ($row = $stmt->fetchObject('Read')) {
			$resultado[] = $row;
		}

		return $resultado;
	}

}
