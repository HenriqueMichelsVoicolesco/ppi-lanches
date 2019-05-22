<?php 
date_default_timezone_set('America/Sao_Paulo');

$dia = date('w');
$nome_dias = ['%Domingo%', '%Segunda-Feira%', 
'%Terça-Feira%', '%Quarta-Feira%', '%Quinta-Feira%', 
'%Sexta-Feira%', '%Sábado%'];

$con = new PDO('mysql:host=localhost;dbname=dblanches', 'root', '');

$query = ('SELECT * FROM turmas WHERE horarios LIKE ?');

// INSERT INTO registros(
//     codigo_aluno,
//     matricula_aluno,
//     turma_aluno
// )
// SELECT
//     codigo,
//     matricula,
//     turma
// FROM
//     alunos
// WHERE
//     codigo = '8a45as54sf8sdf1'

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

$dia++;

echo $dia;

$stmt = $con->prepare($query);
$stmt->bindParam('1', $nome_dias[$dia]);
$stmt->execute();

$selectedRows = $stmt->rowCount();

$result = $stmt->fetchAll();

foreach ($result as $column) { 
	$data = ['id' => $column['id_turma'],
			 'curso' => $column['curso'],
			 'modalidade' => $column['modalidade'],
			 'horarios' => $column['horarios']];
}

var_dump($data);

?>