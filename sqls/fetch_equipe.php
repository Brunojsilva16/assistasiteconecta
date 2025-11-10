<?php

$output = array('error' => false);

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataSource.php';

use Dsource\DataSource;

$database = new DataSource();

$output = array('error' => false);

date_default_timezone_set('America/Sao_Paulo');
$datacad = date("Y-m-d H:i:h");

$dadosii = "<div class='table-responsive'>
<table class='table table-bordered table-striped' style='margin-top:20px; color: #af2846'>
<thead>
	<td colspan='4' align='center' style='color: #af2846; text-transform: uppercase;' ><b>Tabela dos Profissionais Assista<b> </td>
</thead>
<thead>
	<th class='text-center'>Nº</th>
	<th class='text-center'>Nome do Profissional</th>
	<th class='text-center'>Status Pagamento</th>
</thead>
<tbody";

$sqlii = "SELECT i.nome_insc, i.status_insc
		FROM 
			inscricao as i
		WHERE 
			i.equipe = 1
		ORDER BY i.nome_insc ASC";

$resultConut = $database->selectFetchAll($sqlii);

$inicioii = 0;
$numero = $inicioii;
while ($row = $resultConut->fetch(PDO::FETCH_ASSOC)) {
	$numero++;

	$dadosii .=  "<tr>
		<td class='text-center' width='60px'>" . $numero . "</td>
		<td class='text-left' width='340px'>" . $row['nome_insc'] . "</td>
		<td class='text-center' width='200px'>" . $row['status_insc'] . "</td>
	</tr>";
}

$dadosii .= "</tbody>
	</table>
</div>";

echo $dadosii;


// close connection
$database->closeConection();
// echo json_encode($output);
