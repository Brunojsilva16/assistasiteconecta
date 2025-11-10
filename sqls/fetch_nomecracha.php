<?php

$output = array('error' => false);

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataSource.php';

use Dsource\DataSource;

$database = new DataSource();

$output = array('error' => false);

date_default_timezone_set('America/Sao_Paulo');
$datacad = date("Y-m-d H:i:h");

$dados = "<div class='table-responsive'>

<table class='table table-bordered table-striped' style='margin-top:20px;'>
<thead>
	<td colspan='6' align='center' style='color: #af2846; text-transform: uppercase;' ><b>Tabela dos Participantes confirmado<b> </td>
</thead>
<thead>
	<th class='text-center'>Nº</th>
	<th class='text-center'>Nome</th>
	<th class='text-center'>NomeCracá</th>
	<th class='text-center'>Categoria</th>
	<th class='text-center'>Status</th>

</thead>
<tbody";

// echo $dados;

$sql = "SELECT * FROM `inscricao` WHERE `status_insc` = 'Confirmado' OR `status_insc` = 'Isento' ORDER BY `nome_insc` ASC";
$resultConut = $database->selectFetchAll($sql);

$inicio = 0;
$numero = $inicio;
while ($row = $resultConut->fetch(PDO::FETCH_ASSOC)) {
	$numero++;

	$dados .=  "<tr>
		<td class='text-center' width='70px'>" . $numero . "</td>
		<td class='text-left' width='280px'>" . $row['nome_insc'] . "</td>
		<td class='text-center' width='125px'>" . $row['nomecracha_insc'] . "</td>
		<td class='text-center' width='125px'>" . $row['categoria_insc'] . "</td>
		<td class='text-center' width='125px'>" . $row['status_insc'] . "</td>
	</tr>";
}

$dados .= "</tbody>
	</table>
</div>";

echo $dados;
// close connection
$database->closeConection();
// echo json_encode($output);
