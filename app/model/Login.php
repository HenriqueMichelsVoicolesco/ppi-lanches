<?php

class Login
{

	public static function logar($email, $senha)
	{

		$con = Connection::getConn();

		$query = 'SELECT
		    nome
	    FROM
		    servidores
		WHERE
			email = ?
		AND
			senha = ?';

		$stmt = $con->prepare($query);
		$stmt->bindValue('1', $email);
		$stmt->bindValue('2', $senha);

		$stmt->execute();

		$selectedRows = $stmt->rowCount();
		$resultado = $stmt->fetchObject('Login');

		if ($selectedRows > 0) {
			$_SESSION['nome'] = serialize($resultado);
			return true;
		}

		// return $resultado;
	}
}
