<?php 

$con = new PDO('mysql:host=localhost;dbname=dblanches', 'root', '');

$query = ('
	SELECT
		registros.id_registro,
		registros.codigo_aluno,
		registros.matricula_aluno,
		alunos.nome,
		turmas.curso,
		registros.timestamp
	FROM
		registros
	INNER JOIN alunos ON
		(matricula_aluno = matricula)
	INNER JOIN turmas ON
		(turma_aluno = turma);
	');

$stmt = $con->prepare($query);
$stmt->execute();

$selectedRows = $stmt->rowCount();

$result = $stmt->fetchAll();

$response = [];

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="style.css">
	<title>Document</title>
</head>
<body>
	<table>
		<thead>
			<tr>
				<th>Id</th>
				<th>Codigo</th>
				<th>Matricula</th>
				<th>Nome</th>
				<th>Curso</th>
				<th>Time</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if ($selectedRows > 0):
				foreach ($result as $column):
					echo "<tr>";
					echo '<td>' . $column['id_registro'] . '</td>';
					echo '<td>' . $column['codigo_aluno'] . '</td>';
					echo '<td>' . $column['matricula_aluno'] . '</td>';
					echo '<td>' . $column['nome'] . '</td>';
					echo '<td>' . $column['curso'] . '</td>';
					echo '<td>' . $column['timestamp'] . '</td>';
					echo "</tr>";
				endforeach;
			else:
				echo "<tr><td>Sem registros</td></tr>";
			endif;
			?>
		</tbody>
	</table>

</body>
</html>