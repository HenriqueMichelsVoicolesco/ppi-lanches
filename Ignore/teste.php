<?php 

require_once '../lib/Connection.php';

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

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$resultado[] = $row;
        }
        
        echo json_encode($resultado);