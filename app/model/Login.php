<?php

class Login
{

	public static function logar($dadosLogin)
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
		$stmt->bindValue('1', $dadosLogin['email']);
		$stmt->bindValue('2', $dadosLogin['senha']);

		$stmt->execute();

		$selectedRows = $stmt->rowCount();
		$resultado = $stmt->fetchObject('Login');

		if ($selectedRows > 0) {
			$_SESSION['nome'] = serialize($resultado);
			return true;
		}

		return true;
	}
}
