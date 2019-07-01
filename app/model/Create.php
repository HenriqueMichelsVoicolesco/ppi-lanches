<?php

class Create
{

	public function cadastrarAluno($dadosAluno)
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
			return 'cadastrado';
		}
		return 'erro';
	}

	public function cadastrarServidor($dadosServidor)
	{

		$con = Connection::getConn();

		$senha_hash = password_hash($dadosServidor['senha'], PASSWORD_DEFAULT);

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
		$stmt->bindParam('3', $senha_hash);

		$stmt->execute();

		$affectedRows = $stmt->rowCount();

		if ($affectedRows > 0) {
			return 'cadastrado';
		}
		return 'erro';
	}

	public function cadastrarTurma($dadosTurma)
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

		$query = 'INSERT INTO turmas (
			curso, 
			semestre, 
			modalidade,
			dias_lanche,
			reserva_de,
			reserva_ate,
			retirada_de,
			retirada_ate
		) VALUES (
			?, ?, ?, ?, ?, ?, ?, ?
		)';

		$stmt = $con->prepare($query);

		$stmt->bindValue('1', $dadosTurma['curso']);
		$stmt->bindValue('2', $dadosTurma['semestre']);
		$stmt->bindValue('3', $dadosTurma['modalidade']);
		$stmt->bindValue('4', $checkbox);
		$stmt->bindValue('5', $reserva_de->format('H:i:s'));
		$stmt->bindValue('6', $reserva_ate->format('H:i:s'));
		$stmt->bindValue('7', $retirada_de->format('H:i:s'));
		$stmt->bindValue('8', $retirada_ate->format('H:i:s'));

		$stmt->execute();

		$affectedRows = $stmt->rowCount();

		if ($affectedRows > 0) {
			return 'cadastrado';
		}
		return 'erro';
	}

	public function reservarLancheRfid($rfid)
	{

		$con = Connection::getConn();

		$dias_semana = [
			'Domingo', 'Segunda-Feira',
			'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira',
			'Sexta-Feira', 'Sábado'
		];

		$data_atual = new DateTime();
		$num_dia_semana = $data_atual->format('w');

		$query = 'SELECT
			alunos.matricula,
			alunos.nome,
			alunos.turma,
			turmas.dias_lanche,
			turmas.reserva_de,
			turmas.reserva_ate,
			turmas.retirada_de,
			turmas.retirada_ate
		FROM
			alunos
		INNER JOIN turmas ON(id_turma = turma)
		WHERE
			codigo = ?';

		$stmt = $con->prepare($query);

		$stmt->bindParam('1', $rfid);

		$stmt->execute();

		$aluno = $stmt->fetch(PDO::FETCH_ASSOC);
		$affectedRows = $stmt->rowCount();

		//Se na contagem de linhas for maior que 0 (no caso retornará 1) então existe um usuário com aquele rfid
		if ($affectedRows > 0) {

			//Define objetos do tipo dateTime com os horários de reserva e retirada da turma do aluno
			$reserva_de = new DateTime($aluno['reserva_de']);
			$reserva_ate = new DateTime($aluno['reserva_ate']);
			$retirada_de = new DateTime($aluno['retirada_de']);
			$retirada_ate = new DateTime($aluno['retirada_ate']);

			$query = 'SELECT 
				timestamp_reserva, 
				timestamp_retirada
			FROM 
				registros 
			WHERE 
				codigo_aluno = ? 
			AND 
				DATE(timestamp_reserva) = ?';

			$stmt = $con->prepare($query);

			$stmt->bindValue('1', $rfid);
			$stmt->bindValue('2', $data_atual->format('Y-m-d'));

			$stmt->execute();

			$verificacaoRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

			//Se estiver dentro do horário de inserção e do dia de ganhar lanche, e não há nenhum registro de lanche então cria uma reserva
			if (strpos($aluno['dias_lanche'], $dias_semana[$num_dia_semana]) !== false && ($data_atual >= $reserva_de && $data_atual <= $reserva_ate) && ($verificacaoRegistros['timestamp_reserva'] == null && $verificacaoRegistros['timestamp_retirada'] == null)) {

				//Insere um novo registro de reserva
				$query = 'INSERT INTO registros(
					codigo_aluno,
					matricula_aluno,
					turma_aluno,
					timestamp_reserva
				)
				VALUES (?, ?, ?, ?)';

				$stmt = $con->prepare($query);

				$stmt->bindValue('1', $rfid);
				$stmt->bindValue('2', $aluno['matricula']);
				$stmt->bindValue('3', $aluno['turma']);
				$stmt->bindValue('4', $data_atual->format('Y-m-d H:i:s'));

				$stmt->execute();

				$mensagem = ['identificacao' => $aluno['nome'], 'mensagem' => 'Pedido de lanche cadastrado!'];
				echo "reservado_com_sucesso"; //mensagem ao NODEMCU/ARDUINO
			} elseif (strpos($aluno['dias_lanche'], $dias_semana[$num_dia_semana]) !== false && ($data_atual >= $reserva_de && $data_atual <= $reserva_ate) && ($verificacaoRegistros['timestamp_reserva'] != null)) {
				//Se estiver dentro do horário de inserção e do dia de ganha lanche, e já houver uma reserva no dia então imprime que já há um pedido de lanche

				$mensagem = ['identificacao' => $aluno['nome'], 'mensagem' => "O lanche de hoje já foi requisitado!"];
				echo "lanche_ja_reservado"; //mensagem ao NODEMCU/ARDUINO
			} elseif (strpos($aluno['dias_lanche'], $dias_semana[$num_dia_semana]) !== false && ($data_atual >= $retirada_de && $data_atual <= $retirada_ate) && ($verificacaoRegistros['timestamp_reserva'] != null && $verificacaoRegistros['timestamp_retirada'] != null)) {
				//Se estiver dentro do horário de retirada e do dia de ganha lanche, e já houver uma reserva e uma retirada então imprime que já retiraram o lanche

				$mensagem = ['identificacao' => $aluno['nome'], 'mensagem' => "O lanche de hoje já foi retirado!"];
				echo "lancha_ja_retirado"; //mensagem ao NODEMCU/ARDUINO
			} elseif (strpos($aluno['dias_lanche'], $dias_semana[$num_dia_semana]) === false) {
				//Se o usuário tentar reservar o lanche e não for em um dia que ele ganha então será impresso uma mensagem

				$mensagem = ['identificacao' => $aluno['nome'], 'mensagem' => 'Dia invalido, os seus dias de lanche sao ' . str_replace(',', ', ', $aluno['dias_lanche'])];
				echo "dia_invalido"; //mensagem ao NODEMCU/ARDUINO
			} else {
				//Se nenhum dos casos for verdadeiro então significa que o problema está no horário, não está dentro do horário de reserva ou retirada

				$mensagem = ['identificacao' => $aluno['nome'], 'mensagem' => "Você deve solicitar o lanche entre {$reserva_de->format('H:i:s')} - {$reserva_ate->format('H:i:s')} e retirar entre {$retirada_de->format('H:i:s')} - {$retirada_ate->format('H:i:s')}."];
				echo "fora_do_horario"; //mensagem ao NODEMCU/ARDUINO
			}

			//Se não encontrar um registro com o rfid então quer dizer que não há um usuário cadastrado
		} else {
			$mensagem = ['identificacao' => $rfid, 'mensagem' => "Código não encontrado! Certifique-se de possuir um cadastro."];
			echo "codigo_invalido"; //mensagem ao NODEMCU/ARDUINO
		}

		//cria o nome da memoria como o tamanho da palavra
		$key = strlen('reserva');
		//chama a função passando a mensagem e a chave
		SharedMemory::save($key, $mensagem);
	}

	public function reservarLancheMatricula($matricula)
	{
		$con = Connection::getConn();

		$dias_semana = [
			'Domingo', 'Segunda-Feira',
			'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira',
			'Sexta-Feira', 'Sábado'
		];

		$data_atual = new DateTime();
		$num_dia_semana = $data_atual->format('w');

		$query = 'SELECT
			alunos.nome,
			alunos.codigo,
			alunos.turma,
			turmas.dias_lanche,
			turmas.reserva_de,
			turmas.reserva_ate,
			turmas.retirada_de,
			turmas.retirada_ate
		FROM
			alunos
		INNER JOIN turmas ON(id_turma = turma)
		WHERE
			matricula = ?';

		$stmt = $con->prepare($query);

		$stmt->bindParam('1', $matricula);

		$stmt->execute();

		$aluno = $stmt->fetch(PDO::FETCH_ASSOC);
		$affectedRows = $stmt->rowCount();

		//Se na contagem de linhas for maior que 0 (no caso retornará 1) então existe um usuário com aquela matricula
		if ($affectedRows > 0) {

			//Define objetos do tipo dateTime com os horários de reserva e retirada da turma do aluno
			$reserva_de = new DateTime($aluno['reserva_de']);
			$reserva_ate = new DateTime($aluno['reserva_ate']);
			$retirada_de = new DateTime($aluno['retirada_de']);
			$retirada_ate = new DateTime($aluno['retirada_ate']);

			$query = 'SELECT 
				timestamp_reserva, 
				timestamp_retirada
			FROM 
				registros 
			WHERE 
				matricula_aluno = ? 
			AND 
				DATE(timestamp_reserva) = ?';

			$stmt = $con->prepare($query);

			$stmt->bindValue('1', $matricula);
			$stmt->bindValue('2', $data_atual->format('Y-m-d'));

			$stmt->execute();

			$verificacaoRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

			//Se estiver dentro do horário de inserção e do dia de ganhar lanche, e não há nenhum registro de lanche então cria uma reserva
			if (strpos($aluno['dias_lanche'], $dias_semana[$num_dia_semana]) !== false && ($data_atual >= $reserva_de && $data_atual <= $reserva_ate) && ($verificacaoRegistros['timestamp_reserva'] == null && $verificacaoRegistros['timestamp_retirada'] == null)) {

				//Insere um novo registro de reserva
				$query = 'INSERT INTO registros(
					codigo_aluno,
					matricula_aluno,
					turma_aluno,
					timestamp_reserva
				)
				VALUES (?, ?, ?, ?)';

				$stmt = $con->prepare($query);

				$stmt->bindValue('1', $aluno['codigo']);
				$stmt->bindValue('2', $matricula);
				$stmt->bindValue('3', $aluno['turma']);
				$stmt->bindValue('4', $data_atual->format('Y-m-d H:i:s'));

				$stmt->execute();

				$mensagem = ['identificacao' => $aluno['nome'], 'mensagem' => 'Pedido de lanche cadastrado!'];
			} elseif (strpos($aluno['dias_lanche'], $dias_semana[$num_dia_semana]) !== false && ($data_atual >= $reserva_de && $data_atual <= $reserva_ate) && ($verificacaoRegistros['timestamp_reserva'] != null)) {
				//Se estiver dentro do horário de inserção e do dia de ganha lanche, e já houver uma reserva no dia então imprime que já há um pedido de lanche

				$mensagem = ['identificacao' => $aluno['nome'], 'mensagem' => "O lanche de hoje já foi requisitado!"];
			} elseif (strpos($aluno['dias_lanche'], $dias_semana[$num_dia_semana]) !== false && ($data_atual >= $retirada_de && $data_atual <= $retirada_ate) && ($verificacaoRegistros['timestamp_reserva'] != null && $verificacaoRegistros['timestamp_retirada'] != null)) {
				//Se estiver dentro do horário de retirada e do dia de ganha lanche, e já houver uma reserva e uma retirada então imprime que já retiraram o lanche

				$mensagem = ['identificacao' => $aluno['nome'], 'mensagem' => "O lanche de hoje já foi retirado!"];
			} elseif (strpos($aluno['dias_lanche'], $dias_semana[$num_dia_semana]) === false) {
				//Se o usuário tentar reservar o lanche e não for em um dia que ele ganha então será impresso uma mensagem

				$mensagem = ['identificacao' => $aluno['nome'], 'mensagem' => 'Dia invalido, os seus dias de lanche sao ' . str_replace(',', ', ', $aluno['dias_lanche'])];
			} else {
				//Se nenhum dos casos for verdadeiro então significa que o problema está no horário, não está dentro do horário de reserva ou retirada

				$mensagem = ['identificacao' => $aluno['nome'], 'mensagem' => "Você deve solicitar o lanche entre {$reserva_de->format('H:i:s')} - {$reserva_ate->format('H:i:s')} e retirar entre {$retirada_de->format('H:i:s')} - {$retirada_ate->format('H:i:s')}."];
			}

			//Se não encontrar um registro com a matricula então quer dizer que não há um usuário cadastrado
		} else {
			$mensagem = ['identificacao' => $matricula, 'mensagem' => "Matrícula não encontrada! Certifique-se de possuir um cadastro."];
		}

		//cria o nome da memoria como o tamanho da palavra
		$key = strlen('reserva');
		//chama a função passando a mensagem e a chave
		SharedMemory::save($key, $mensagem);
	}

	public function retirarLancheRfid($rfid)
	{

		$con = Connection::getConn();

		$dias_semana = [
			'Domingo', 'Segunda-Feira',
			'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira',
			'Sexta-Feira', 'Sábado'
		];

		$data_atual = new DateTime();
		$num_dia_semana = $data_atual->format('w');

		$query = 'SELECT
			alunos.matricula,
			alunos.nome,
			alunos.turma,
			turmas.dias_lanche,
			turmas.reserva_de,
			turmas.reserva_ate,
			turmas.retirada_de,
			turmas.retirada_ate
		FROM
			alunos
		INNER JOIN turmas ON(id_turma = turma)
		WHERE
			codigo = ?';

		$stmt = $con->prepare($query);

		$stmt->bindParam('1', $rfid);

		$stmt->execute();

		$aluno = $stmt->fetch(PDO::FETCH_ASSOC);
		$affectedRows = $stmt->rowCount();

		//Se na contagem de linhas for maior que 0 (no caso retornará 1) então existe um usuário com aquele rfid
		if ($affectedRows > 0) {

			//Define objetos do tipo dateTime com os horários de reserva e retirada da turma do aluno
			$reserva_de = new DateTime($aluno['reserva_de']);
			$reserva_ate = new DateTime($aluno['reserva_ate']);
			$retirada_de = new DateTime($aluno['retirada_de']);
			$retirada_ate = new DateTime($aluno['retirada_ate']);

			$query = 'SELECT 
				timestamp_reserva, 
				timestamp_retirada
			FROM 
				registros 
			WHERE 
				codigo_aluno = ? 
			AND 
				DATE(timestamp_reserva) = ?';

			$stmt = $con->prepare($query);

			$stmt->bindValue('1', $rfid);
			$stmt->bindValue('2', $data_atual->format('Y-m-d'));

			$stmt->execute();

			$verificacaoRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

			//Se estiver dentro do horário de retirada e do dia de ganha lanche, e houver uma reserva do dia então atualiza-se o registro com a retirada
			if (strpos($aluno['dias_lanche'], $dias_semana[$num_dia_semana]) !== false && ($data_atual >= $retirada_de && $data_atual <= $retirada_ate) && ($verificacaoRegistros['timestamp_reserva'] != null && $verificacaoRegistros['timestamp_retirada'] == null)) {

				//Atualiza o registro de reserva inserindo o horário de retirada de acordo com o rfid e o dia
				$query = 'UPDATE registros
				SET
					timestamp_retirada = ?
				WHERE
					codigo_aluno = ? 
				AND
					DATE(timestamp_reserva) = ?';

				$stmt = $con->prepare($query);

				$stmt->bindValue('1', $data_atual->format('Y-m-d H:i:s'));
				$stmt->bindValue('2', $rfid);
				$stmt->bindValue('3', $data_atual->format('Y-m-d'));

				$stmt->execute();

				$mensagem = ['identificacao' => $aluno['nome'], 'mensagem' => 'Lanche retirado!'];
				echo "retirado_com_sucesso"; //mensagem ao NODEMCU/ARDUINO
			} elseif (strpos($aluno['dias_lanche'], $dias_semana[$num_dia_semana]) !== false && ($data_atual >= $retirada_de && $data_atual <= $retirada_ate) && ($verificacaoRegistros['timestamp_reserva'] == null)) {
				//Se estiver dentro do horário de retirada e do dia de ganha lanche, e não houver nenhum registro de reserva do dia então imprime que não se pode retirar o lanche sem pedir

				$mensagem = ['identificacao' => $aluno['nome'], 'mensagem' => "Não é possível retirar sem pedir o lanche!"];
				echo "lanche_nao_reservado"; //mensagem ao NODEMCU/ARDUINO
			} elseif (strpos($aluno['dias_lanche'], $dias_semana[$num_dia_semana]) !== false && ($data_atual >= $retirada_de && $data_atual <= $retirada_ate) && ($verificacaoRegistros['timestamp_reserva'] != null && $verificacaoRegistros['timestamp_retirada'] != null)) {
				//Se estiver dentro do horário de retirada e do dia de ganha lanche, e já houver uma reserva e uma retirada então imprime que já retiraram o lanche

				$mensagem = ['identificacao' => $aluno['nome'], 'mensagem' => "O lanche de hoje já foi retirado!"];
				echo "lancha_ja_retirado"; //mensagem ao NODEMCU/ARDUINO
			} elseif (strpos($aluno['dias_lanche'], $dias_semana[$num_dia_semana]) === false) {
				//Se o usuário tentar reservar o lanche e não for em um dia que ele ganha então será impresso uma mensagem

				$mensagem = ['identificacao' => $aluno['nome'], 'mensagem' => 'Dia invalido, os seus dias de lanche sao ' . str_replace(',', ', ', $aluno['dias_lanche'])];
				echo "dia_invalido"; //mensagem ao NODEMCU/ARDUINO
			} else {
				//Se nenhum dos casos for verdadeiro então significa que o problema está no horário, não está dentro do horário de reserva ou retirada

				$mensagem = ['identificacao' => $aluno['nome'], 'mensagem' => "Você deve solicitar o lanche entre {$reserva_de->format('H:i:s')} - {$reserva_ate->format('H:i:s')} e retirar entre {$retirada_de->format('H:i:s')} - {$retirada_ate->format('H:i:s')}."];
				echo "fora_do_horario"; //mensagem ao NODEMCU/ARDUINO
			}

			//Se não encontrar um registro com o rfid então quer dizer que não há um usuário cadastrado
		} else {
			$mensagem = ['identificacao' => $rfid, 'mensagem' => "Código não encontrada! Certifique-se de possuir um cadastro."];
			echo "codigo_invalido"; //mensagem ao NODEMCU/ARDUINO
		}

		//cria o nome da memoria como o tamanho da palavra
		$key = strlen('retirada');
		//chama a função passando a mensagem e a chave
		SharedMemory::save($key, $mensagem);
	}

	public function retirarLancheMatricula($matricula)
	{
		$con = Connection::getConn();

		$dias_semana = [
			'Domingo', 'Segunda-Feira',
			'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira',
			'Sexta-Feira', 'Sábado'
		];

		$data_atual = new DateTime();
		$num_dia_semana = $data_atual->format('w');

		$query = 'SELECT
			alunos.nome,
			alunos.codigo,
			alunos.turma,
			turmas.dias_lanche,
			turmas.reserva_de,
			turmas.reserva_ate,
			turmas.retirada_de,
			turmas.retirada_ate
		FROM
			alunos
		INNER JOIN turmas ON(id_turma = turma)
		WHERE
			matricula = ?';

		$stmt = $con->prepare($query);

		$stmt->bindParam('1', $matricula);

		$stmt->execute();

		$aluno = $stmt->fetch(PDO::FETCH_ASSOC);
		$affectedRows = $stmt->rowCount();

		//Se na contagem de linhas for maior que 0 (no caso retornará 1) então existe um usuário com aquela matricula
		if ($affectedRows > 0) {

			//Define objetos do tipo dateTime com os horários de reserva e retirada da turma do aluno
			$reserva_de = new DateTime($aluno['reserva_de']);
			$reserva_ate = new DateTime($aluno['reserva_ate']);
			$retirada_de = new DateTime($aluno['retirada_de']);
			$retirada_ate = new DateTime($aluno['retirada_ate']);

			$query = 'SELECT 
				timestamp_reserva, 
				timestamp_retirada
			FROM 
				registros 
			WHERE 
				matricula_aluno = ? 
			AND 
				DATE(timestamp_reserva) = ?';

			$stmt = $con->prepare($query);

			$stmt->bindValue('1', $matricula);
			$stmt->bindValue('2', $data_atual->format('Y-m-d'));

			$stmt->execute();

			$verificacaoRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

			//Se estiver dentro do horário de retirada e do dia de ganha lanche, e houver uma reserva do dia então atualiza-se o registro com a retirada
			if (strpos($aluno['dias_lanche'], $dias_semana[$num_dia_semana]) !== false && ($data_atual >= $retirada_de && $data_atual <= $retirada_ate) && ($verificacaoRegistros['timestamp_reserva'] != null && $verificacaoRegistros['timestamp_retirada'] == null)) {

				//Atualiza o registro de reserva inserindo o horário de retirada de acordo com o rfid e o dia
				$query = 'UPDATE registros
				SET
					timestamp_retirada = ?
				WHERE
					matricula_aluno = ? 
				AND
					DATE(timestamp_reserva) = ?';

				$stmt = $con->prepare($query);

				$stmt->bindValue('1', $data_atual->format('Y-m-d H:i:s'));
				$stmt->bindValue('2', $matricula);
				$stmt->bindValue('3', $data_atual->format('Y-m-d'));

				$stmt->execute();

				$mensagem = ['identificacao' => $aluno['nome'], 'mensagem' => 'Lanche retirado!'];
			} elseif (strpos($aluno['dias_lanche'], $dias_semana[$num_dia_semana]) !== false && ($data_atual >= $retirada_de && $data_atual <= $retirada_ate) && ($verificacaoRegistros['timestamp_reserva'] == null)) {
				//Se estiver dentro do horário de retirada e do dia de ganha lanche, e não houver nenhum registro de reserva do dia então imprime que não se pode retirar o lanche sem pedir

				$mensagem = ['identificacao' => $aluno['nome'], 'mensagem' => "Não é possível retirar sem pedir o lanche!"];
			} elseif (strpos($aluno['dias_lanche'], $dias_semana[$num_dia_semana]) !== false && ($data_atual >= $retirada_de && $data_atual <= $retirada_ate) && ($verificacaoRegistros['timestamp_reserva'] != null && $verificacaoRegistros['timestamp_retirada'] != null)) {
				//Se estiver dentro do horário de retirada e do dia de ganha lanche, e já houver uma reserva e uma retirada então imprime que já retiraram o lanche

				$mensagem = ['identificacao' => $aluno['nome'], 'mensagem' => "O lanche de hoje já foi retirado!"];
			} elseif (strpos($aluno['dias_lanche'], $dias_semana[$num_dia_semana]) === false) {
				//Se o usuário tentar reservar o lanche e não for em um dia que ele ganha então será impresso uma mensagem

				$mensagem = ['identificacao' => $aluno['nome'], 'mensagem' => 'Dia invalido, os seus dias de lanche sao ' . str_replace(',', ', ', $aluno['dias_lanche'])];
			} else {
				//Se nenhum dos casos for verdadeiro então significa que o problema está no horário, não está dentro do horário de reserva ou retirada

				$mensagem = ['identificacao' => $aluno['nome'], 'mensagem' => "Você deve solicitar o lanche entre {$reserva_de->format('H:i:s')} - {$reserva_ate->format('H:i:s')} e retirar entre {$retirada_de->format('H:i:s')} - {$retirada_ate->format('H:i:s')}."];
			}

			//Se não encontrar um registro com a matricula então quer dizer que não há um usuário cadastrado
		} else {
			$mensagem = ['identificacao' => $matricula, 'mensagem' => "Matrícula não encontrada! Certifique-se de possuir um cadastro."];
		}
		
		//cria o nome da memoria como o tamanho da palavra
		$key = strlen('retirada');
		//chama a função passando a mensagem e a chave
		SharedMemory::save($key, $mensagem);
	}
}
