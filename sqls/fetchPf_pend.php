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
	<td colspan='7' align='center' style='color: #af2846; text-transform: uppercase;' ><b>Tabela dos Participantes sem pagamento confirmado<b> </td>
</thead>
<thead>
	<th class='text-center'>Nº</th>
	<th class='text-center'>Nome</th>
	<th class='text-center'>Telefone</th>
	<th class='text-center'>Status</th>
	<th class='text-center'>Data</th>
	<th class='text-center'>Ação</th>
</thead>
<tbody";

// echo $dados;

$sql = "SELECT * FROM `papo` WHERE status_insc is null ORDER BY `datacad` DESC";
$resultConut = $database->selectFetchAll($sql);

$inicio = 0;
$numero = $inicio;
while ($row = $resultConut->fetch(PDO::FETCH_ASSOC)) {
	$numero++;

	$acao = ($row['status_insc'] != 'Confirmado') ? '<button class="btn btn-outline-success" onclick="getPf_param(this);" data-p="1" data-v="Confirmado" data-id="' . $row['id_insc'] . '"><i class="fas fa-solid fa-check"></i></button> <button type="button" class="btn btn-outline-warning" onclick="getPf_param(this);" data-p="1" data-v="Cancelado" data-id="' . $row['id_insc'] . '"><i class="fas fa-times" aria-hidden="true"></i>
</button>' :
		'<button type="button" class="btn btn-outline-danger" onclick="getPf_param(this);" data-p="1" data-v="Cancelado" data-id="' . $row['id_insc'] . '"><i class="fas fa-times" aria-hidden="true"></i>
</button>';

	$dados .=  "<tr>
		<td class='text-center' width='70px'>" . $numero . "</td>
		<td class='text-left' width='280px'>" . $row['nome_insc'] . "</td>
		<td class='text-left' width='180px'>" . $row['telefone_insc'] . "</td>
		<td class='text-left' width='14px'>" . 'Pendentes' . "</td>

		<td class='text-center' max-width='125px'>
			" . date_format(date_create($row['datacad']), 'd/m/Y') . "
		</td>
		<td class='text-center' width='160px'> $acao </td>
	</tr>";
}

$dados .= "</tbody>
	</table>
</div>";

echo $dados;
// close connection
$database->closeConection();
// echo json_encode($output);
