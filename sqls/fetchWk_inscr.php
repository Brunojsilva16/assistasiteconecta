<?php

$output = array('error' => false);

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataSource.php';

use Dsource\DataSource;

$database = new DataSource();

$output = array('error' => false);

date_default_timezone_set('America/Sao_Paulo');
$datacad = date("Y-m-d H:i:h");


$dados = "
<div class='card-fixedWidth'>
    <div class='card_header'>
        Total de inscritos
    </div>
    <div class='card_content'>
        <p class='card_text'>
            <span class='inscritos'></span>
        </p>
    </div>
</div>
<div class='card-fixedWidth'>
    <div class='card_header'>
        Confirmados
    </div>
    <div class='card_content'>
        <p class='card_text'>
            <span class='confirmados'></span>
        </p>
    </div>
</div>
<div class='card-fixedWidth'>
    <div class='card_header'>
        Pendentes
    </div>
    <div class='card_content'>
        <p class='card_text'>
            <span class='pendentes'></span>
        </p>
    </div>
</div>
<div class='card-fixedWidth'>
    <div class='card_header'>
        Desistente / Cancelados
    </div>
    <div class='card_content'>
        <p class='card_text'>
            <span class='cancelados'></span>
        </p>
    </div>
</div>
<hr>
";

$dados .= "<div class='table-responsive'>
<table class='table table-bordered table-striped' style='margin-top:20px;'>
<thead>
	<th class='text-center'>Nº</th>
	<th class='text-center'>Nome</th>
	<th class='text-center'>Categoria</th>
	<th class='text-center'>Telefone</th>
	<th class='text-center'>Status</th>
	<th class='text-center'>Data</th>
	<th class='text-center'>Anexo</th>
	<th class='text-center'>Ação</th>
</thead>
<tbody";


// echo $dados;

$sql = "SELECT * FROM `workshop` ORDER BY `datacad` DESC";
$resultConut = $database->selectFetchAll($sql);


$inicio = 0;
$numero = $inicio;
while ($row = $resultConut->fetch(PDO::FETCH_ASSOC)) {
    $numero++;

    $docfile = (!empty($row['doc_insc'])) ? '../assets/uploads/' . $row['doc_insc'] : null;

    if (file_exists($docfile)) {

        $viewDoc = '<span class="pull-right"><a href="./assets/uploads/' . $row['doc_insc'] . '" target="_blank" class="btn btn-secondary btn-md"><i class="fas fa-file-download" aria-hidden="true"></i> CRP</a></span>';
    } else {
        $viewDoc = '<span class="pull-right"><a href="#" class="btn btn-dark btn-md alert_i" data-id="Nenhum documento encontrado!" data-toggle="modal" ><i class="fas fa-file-excel" aria-hidden="true"></i></a></span>';
    }

    $acao = ($row['status_insc'] != 'Confirmado') ? '<button onclick="getWk_param(this);" class="btn btn-outline-success" data-v="Confirmado" data-id="' . $row['id_insc'] . '"><i class="fas fa-solid fa-check"></i></button> <button type="button" onclick="getWk_param(this);" class="btn btn-outline-danger" data-v="Cancelado" data-id="' . $row['id_insc'] . '"><i class="fas fa-times" aria-hidden="true"></i>
</button>' :
        '<button type="button" onclick="getWk_param(this);" class="btn btn-outline-danger" data-v="Cancelado" data-id="' . $row['id_insc'] . '"><i class="fas fa-times" aria-hidden="true"></i>
</button>';

    $dados .=  "<tr>
		<td class='text-center' width='70px'>" . $numero . "</td>
		<td class='text-left' width='280px'>" . $row['nome_insc'] . "</td>
		<td class='text-center' width='125px'>" . $row['categoria_insc'] . "</td>
		<td class='text-left' width='180px'>" . $row['telefone_insc'] . "</td>
		<td class='text-left' width='14px'>" . $row['status_insc'] . "</td>
        
		<td class='text-center' max-width='125px'>
        " . date_format(date_create($row['datacad']), 'd/m/Y') . "
		</td>
        <td class='text-center' width='130px'> $viewDoc	</td>
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
