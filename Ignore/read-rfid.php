<?php
date_default_timezone_set('America/Sao_Paulo');

$rfid = $_POST['rfid'] ?? '8a45as54sf8sdf1';

$nome_dias = [
	'%Domingo%', '%Segunda-Feira%',
	'%Terça-Feira%', '%Quarta-Feira%', '%Quinta-Feira%',
	'%Sexta-Feira%', '%Sábado%'
];

$inicio = new DateTime('13:00:00');
$fim = new DateTime('14:30:00');
$entrada = new DateTime();
$dia = $entrada->format('w');

var_dump($dia);

echo "<br>$nome_dias[$dia]<br>";

if ($entrada > $inicio && $entrada < $fim) {
	echo "Permitido!";
} else {
	echo "Negado!";
}

// $con = new PDO('mysql:host=localhost;dbname=dblanches', 'root', '');

// $query = ('select count(*) from registros where codigo_aluno = ? AND DATE(timestamp) = ?');

// $stmt = $con->prepare($query);
// $stmt->bindParam('1', $rfid);
// $stmt->bindParam('2', $timestamp);
// $stmt->execute();

// var_dump($userReads = $stmt->fetchColumn());

// if ($userReads > 2) {
// 	echo 'Limite excedido!';
// } else {
	
// 	$query = ('
// 		INSERT INTO registros(
// 			codigo_aluno,
// 			matricula_aluno,
// 			turma_aluno
// 		)
// 		SELECT
// 			alunos.codigo,
// 			alunos.matricula,
// 			alunos.turma
// 		FROM
// 			alunos
// 		INNER JOIN turmas ON
// 			(turma = id_turma)
// 		WHERE
// 			alunos.codigo = ? AND turmas.horarios LIKE ?
// 		');

// 	$stmt = $con->prepare($query);
// 	$stmt->bindParam('1', $rfid);
// 	$stmt->bindParam('2', $nome_dias[$dia]);
// 	$stmt->execute();

// 	$selectedRows = $stmt->rowCount();

// 	if ($selectedRows > 0) { 
// 		echo 'Inserido com sucesso!!!';
// 	} else {
// 		echo 'Erro ao inserir!!!';
// 	}

// }



// SQL para exibir na tabela de pedidos
// SELECT
//     registros.id_registro,
//     registros.codigo_aluno,
//     registros.matricula_aluno,
//     alunos.nome,
//     turmas.curso,
//     registros.timestamp
// FROM
//     registros
// INNER JOIN alunos ON
//     (matricula_aluno = matricula)
// INNER JOIN turmas ON
//     (turma_aluno = turma);
