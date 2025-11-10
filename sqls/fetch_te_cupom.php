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
	<td colspan='4' align='center' style='color: #af2846; text-transform: uppercase;'><b>Tabela de cupons usados nas vendas<b> </td>
</thead>
<thead>
	<th class='text-center'>Nº</th>
	<th class='text-center'>Profissional</th>
	<th class='text-center'>Código do cupom</th>
	<th class='text-center'>Cupons usados</th>
</thead>
<tbody";

$sql = "SELECT i.cupom_insc, cd.nome_cod, COUNT(*) AS insc_cupom
		FROM 
			te_inscricao as i
		LEFT JOIN 
			codigo as cd on i.cupom_insc = cd.codigo_cod
		WHERE 
			i.status_insc = 'Confirmado' OR i.status_insc = 'Isento'
		GROUP BY 
			i.cupom_insc
		ORDER BY insc_cupom ASC";
$resultConut = $database->selectFetchAll($sql);

$inicio = 0;
$numero = $inicio;
while ($row = $resultConut->fetch(PDO::FETCH_ASSOC)) {
	$numero++;

	$retVal = ($row['cupom_insc'] == NULL) ? 'Sem cupom' : $row['cupom_insc'];
	$retValtow = ($row['nome_cod'] == NULL) ? 'Expontâneo' : $row['nome_cod'];

	$dados .=  "<tr>
		<td class='text-center' width='60px'>" . $numero . "</td>
		<td class='text-left' width='250px'>" . $retValtow . "</td>
		<td class='text-center' width='180px'>" . $retVal . "</td>
		<td class='text-center' width='200px'>" . $row['insc_cupom'] . "</td>
	</tr>";
}

$dados .= "</tbody>
	</table>
</div>";

echo $dados;

$dadosii = "<div class='table-responsive'>
<table class='table table-bordered table-striped' style='margin-top:20px;'>
<thead>
	<td colspan='4' align='center' style='color: #af2846; text-transform: uppercase;'><b>Tabela de cupons usado por participante<b> </td>
</thead>
<thead>
	<th class='text-center'>Nº</th>
	<th class='text-center'>Nome participante</th>
	<th class='text-center'>Código do cupom</th>
	<th class='text-center'>Profissional Venda</th>
</thead>
<tbody";

$sqlii = "SELECT i.nome_insc, i.cupom_insc, cd.nome_cod
		FROM 
			te_inscricao as i
		LEFT JOIN 
			codigo as cd on i.cupom_insc = cd.codigo_cod
		WHERE 
			i.status_insc = 'Confirmado' OR i.status_insc = 'Isento'
		ORDER BY i.cupom_insc ASC";

$resultConut = $database->selectFetchAll($sqlii);

$inicioii = 0;
$numero = $inicioii;
while ($row = $resultConut->fetch(PDO::FETCH_ASSOC)) {
	$numero++;

	$retValthree = ($row['cupom_insc'] == NULL) ? 'Sem cupom' : $row['cupom_insc'];
	$retValfour = ($row['nome_cod'] == NULL) ? 'Expontâneo' : $row['nome_cod'];

	$dadosii .=  "<tr>
		<td class='text-center' width='60px'>" . $numero . "</td>
		<td class='text-left' width='250px'>" . $row['nome_insc'] . "</td>
		<td class='text-center' width='180px'>" . $retValthree . "</td>
		<td class='text-center' width='200px'>" . $retValfour . "</td>
	</tr>";
}

$dadosii .= "</tbody>
	</table>
</div>";

echo $dadosii;



















// close connection
$database->closeConection();
// echo json_encode($output);
