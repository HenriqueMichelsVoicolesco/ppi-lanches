<?php

class Login
{

	public function logar($dadosLogin)
	{

		$con = Connection::getConn();

		$query = 'SELECT
		    nome,
			senha
	    FROM
		    servidores
		WHERE
			email = ?';

		$stmt = $con->prepare($query);
		$stmt->bindParam('1', $dadosLogin['email']);

		$stmt->execute();

		$selectedRows = $stmt->rowCount();
		$resultado = $stmt->fetchObject('Login');

		if ($selectedRows > 0 && password_verify($dadosLogin['senha'], $resultado->senha)) {
			$_SESSION['nome'] = serialize($resultado->nome);
		}

		return true;
	}
}
