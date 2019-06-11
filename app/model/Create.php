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
		$stmt->bindParam('2', $dadosAluno['nome_aluno']);
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
		$stmt->bindParam('2', $dadosServidor['nome_servidor']);
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

		$checkbox = implode(',', $dadosTurma['diasLanche']);

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
		$stmt->bindParam('4', $checkbox);
		$stmt->execute();

		$affectedRows = $stmt->rowCount();

		if ($affectedRows > 0) {
			return true;
		}
	}

	public function cadastrarRegistro($rfid)
	{
		$con = Connection::getConn();

		$dadosRegistro = $rfid;

		$nome_dias = [
			'%Domingo%', '%Segunda-Feira%',
			'%Terça-Feira%', '%Quarta-Feira%', '%Quinta-Feira%',
			'%Sexta-Feira%', '%Sábado%'
		];

		$entrada = new DateTime();
		$dia = $entrada->format('w');

		$query = 'SELECT
			turmas.horario_inicio,
			turmas.horario_fim
		FROM
			alunos
		INNER JOIN turmas ON(id_turma = turma)
		WHERE
			codigo = ?';

		$stmt = $con->prepare($query);

		$stmt->bindParam('1', $dadosRegistro);

		$stmt->execute();

		$userReads = $stmt->fetch();
		$affectedRows = $stmt->rowCount();

		//URL para testar:
		//http://localhost/github/ppi-lanches/?pagina=create&metodo=registro&id=8a45as54sf8sdf1
		if ($affectedRows > 0) {
			
			$inicio = new DateTime($userReads['horario_inicio']);
			$fim = new DateTime($userReads['horario_fim']);
			$inicioR = new DateTime('15:40:00');
			$fimR = new DateTime('16:00:00');
			// var_dump($userReads, $inicio, $fim, $entrada);

			if ($entrada > $inicio && $entrada < $fim) {
				echo 'É possível cadastrar!';
			} elseif ($entrada > $inicioR && $entrada < $fimR){
				echo 'É possível retirar o lanche!';
			} else {
				echo "Horário inválido: {$entrada->format('H:i:s')}! Você deve solicitar o lanche entre {$inicio->format('H:i:s')} a {$fim->format('H:i:s')}.";
			}
		} else {
			echo 'Usuário não encontrado! Certifique-se de possuir um cadastro.';
		}
	}
}
