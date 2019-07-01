<?php

class Update
{

	public function atualizarAluno($dadosAluno)
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
		$stmt->bindParam('2', $dadosAluno['nome_aluno']);
		$stmt->bindParam('3', $dadosAluno['rfid']);
		$stmt->bindParam('4', $dadosAluno['turma']);
		$stmt->bindParam('5', $dadosAluno['id_aluno']);
		
		$stmt->execute();

		$affectedRows = $stmt->rowCount();

		var_dump($affectedRows);

		if ($affectedRows > 0) {
			return 'atualizado';
		}
		return 'erro';
	}

	public function atualizarServidor($dadosServidor)
	{

		$con = Connection::getConn();

		$senha_hash = password_hash($dadosServidor['senha'], PASSWORD_DEFAULT);

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
		$stmt->bindParam('2', $dadosServidor['nome_servidor']);
		$stmt->bindParam('3', $senha_hash);
		$stmt->bindParam('4', $dadosServidor['id_servidor']);

		$stmt->execute();

		$affectedRows = $stmt->rowCount();

		if ($affectedRows > 0) {
			return 'atualizado';
		}
		return 'erro';
	}

	public function atualizarTurma($dadosTurma)
	{

		$con = Connection::getConn();

		$checkbox = implode(',', $dadosTurma['diasLanche']);

		$reserva_de = new DateTime($dadosTurma['reserva_de']);
		$reserva_ate = new DateTime($dadosTurma['reserva_ate']);
		$retirada_de = new DateTime($dadosTurma['retirada_de']);
		$retirada_ate = new DateTime($dadosTurma['retirada_ate']);

		if ($reserva_ate < $reserva_de) {
			$reserva_de = new DateTime($dadosTurma['reserva_ate']);
			$reserva_ate = new DateTime($dadosTurma['reserva_de']);
		}

		if ($retirada_ate < $retirada_de) {
			$retirada_de = new DateTime($dadosTurma['retirada_ate']);
			$retirada_ate = new DateTime($dadosTurma['retirada_de']);
		}

		$query = 'UPDATE
			turmas
		SET
			curso = ?,
			semestre = ?,
			modalidade = ?,
			dias_lanche = ?,
			reserva_de = ?,
			reserva_ate = ?,
			retirada_de = ?,
			retirada_ate = ?
		WHERE
			id_turma = ?';
		
		$stmt = $con->prepare($query);

		$stmt->bindValue('1', $dadosTurma['curso']);
		$stmt->bindValue('2', $dadosTurma['semestre']);
		$stmt->bindValue('3', $dadosTurma['modalidade']);
		$stmt->bindValue('4', $checkbox);
		$stmt->bindValue('5', $reserva_de->format('H:i:s'));
		$stmt->bindValue('6', $reserva_ate->format('H:i:s'));
		$stmt->bindValue('7', $retirada_de->format('H:i:s'));
		$stmt->bindValue('8', $retirada_ate->format('H:i:s'));
		$stmt->bindValue('9', $dadosTurma['id_turma']);

		$stmt->execute();

		return 'atualizado';
	}
}
