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
        Confirmados pago
    </div>
    <div class='card_content'>
        <p class='card_text'>
            <span class='confirmados-pago'></span>
        </p>
    </div>
</div>
<div class='card-fixedWidth'>
    <div class='card_header'>
        Confirmados isento
    </div>
    <div class='card_content'>
        <p class='card_text'>
            <span class='confirmados-isento'></span>
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
	<th class='text-center'>Telefone</th>
	<th class='text-center'>Status</th>
	<th class='text-center'>Categoria</th>
	<th class='text-center'>Data</th>
	<th class='text-center'>Ação</th>
</thead>
<tbody";


// echo $dados;

$sql = "SELECT * FROM `papo_two` ORDER BY `datacad` DESC";
$resultConut = $database->selectFetchAll($sql);


$inicio = 0;
$numero = $inicio;
while ($row = $resultConut->fetch(PDO::FETCH_ASSOC)) {
    $numero++;


    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    // if ($_SESSION['nivel_accesso'] > 3) {

    //     $acao = ($row['status_insc'] != 'Confirmado') ? '<button onclick="getPf_param(this);" class="btn btn-outline-success" data-v="Confirmado" data-id="' . $row['id_insc'] . '"><i class="fas fa-solid fa-check"></i></button> <button type="button" onclick="getPf_param(this);" class="btn btn-outline-warning" data-v="Cancelado" data-id="' . $row['id_insc'] . '"><i class="fas fa-times" aria-hidden="true"></i>
    //     </button> <button type="button" onclick="get_delete(this);" class="btn btn-outline-danger" data-page="pf_inscricao" data-bd="papo" data-idbd="id_insc" data-id="' . $row['id_insc'] . '"><i class="fa-solid fa-trash"></i></button>' 
    //     : '<button type="button" onclick="getPf_param(this);" class="btn btn-outline-warning" data-v="Cancelado" data-id="' . $row['id_insc'] . '"><i class="fas fa-times" aria-hidden="true"></i></button> <button type="button" onclick="get_delete(this);" class="btn btn-outline-danger" data-page="pf_inscricao" data-bd="papo" data-idbd="id_insc" data-id="' . $row['id_insc'] . '"><i class="fa-solid fa-trash"></i></button>';
    // } else {
    //     $acao = ($row['status_insc'] != 'Confirmado') ? '<button onclick="getPf_param(this);" class="btn btn-outline-success" data-v="Confirmado" data-id="' . $row['id_insc'] . '"><i class="fas fa-solid fa-check"></i></button> <button type="button" onclick="getPf_param(this);" class="btn btn-outline-warning" data-v="Cancelado" data-id="' . $row['id_insc'] . '"><i class="fas fa-times" aria-hidden="true"></i>
    //     </button>' : '<button type="button" onclick="getPf_param(this);" class="btn btn-outline-warning" data-v="Cancelado" data-id="' . $row['id_insc'] . '"><i class="fas fa-times" aria-hidden="true"></i></button> ';
    // }

    //     $acao = ($row['status_insc'] != 'Confirmado') ? '<button onclick="getPf_param(this);" class="btn btn-outline-success" data-v="Confirmado" data-id="' . $row['id_insc'] . '"><i class="fas fa-solid fa-check"></i></button> <button type="button" onclick="getWk_param(this);" class="btn btn-outline-danger" data-v="Cancelado" data-id="' . $row['id_insc'] . '"><i class="fas fa-times" aria-hidden="true"></i>
    // </button>' :
    //         '<button type="button" onclick="getPf_param(this);" class="btn btn-outline-warning" data-v="Cancelado" data-id="' . $row['id_insc'] . '"><i class="fas fa-times" aria-hidden="true"></i>
    // </button>';

    $botao_conf = '<button type="button" onclick="getPf_param(this);" class="btn btn-outline-success" data-v="Confirmado" title="confirmar" data-id="' . $row['id_insc'] . '"><i class="fas fa-solid fa-check"></i></button>';
    $botao_isent = '<button type="button" onclick="getPf_param(this);" class="btn btn-outline-info" data-v="Isento" title="Isentar" data-id="' . $row['id_insc'] . '"><i class="fa-solid fa-pen"></i></button>';
    $botao_canc = '<button type="button" onclick="getPf_param(this);" class="btn btn-outline-warning" data-v="Cancelado" title="Cancelar" data-id="' . $row['id_insc'] . '"><i class="fas fa-times" aria-hidden="true"></i></button>';
    $botao_del = '<button type="button" onclick="get_delete(this);" class="btn btn-outline-danger" data-page="subpage-Papo2-1" data-bd="papo_two" data-idbd="id_insc" data-id="' . $row['id_insc'] . '"><i class="fa-solid fa-trash"></i></button>';

    $acao = '';
    if ($_SESSION['nivel_accesso'] > 3) {

        switch ($row['status_insc']) {
            case 'Confirmado':
                $acao = $botao_isent . ' ' . $botao_canc . ' ' . $botao_del;
                break;
            case 'Cancelado':
                $acao = $botao_conf . ' ' . $botao_isent . ' ' . $botao_del;
                break;
            case 'Isento':
                $acao = $botao_conf . ' ' . $botao_canc . ' ' . $botao_del;
                break;
            case '':
                $acao = $botao_conf . ' ' . $botao_canc . ' ' . $botao_isent . ' ' .  $botao_del;
                break;

            default:
                $acao;
                break;
        }
    } else {
        switch ($row['status_insc']) {
            case 'Confirmado':
                $acao = $botao_isent . ' ' . $botao_canc;
                break;
            case 'Cancelado':
                $acao = $botao_conf . ' ' . $botao_isent;
                break;
            case 'Isento':
                $acao = $botao_conf . ' ' . $botao_canc;
                break;
            case '':
                $acao = $botao_conf . ' ' . $botao_canc . ' ' . $botao_isent;
                break;

            default:
                $acao;
                break;
        }
    }

    $dados .=  "<tr>
        <td class='text-center' width='70px'>" . $numero . "</td>
        <td class='text-left' width='280px'>" . $row['nome_insc'] . "</td>
        <td class='text-center' width='125px'>" . $row['categoria_insc'] . "</td>
        <td class='text-left' width='180px'>" . $row['telefone_insc'] . "</td>
        <td class='text-left' width='14px'>" . $row['status_insc'] . "</td>

        <td class='text-center' max-width='125px'>
        " . date_format(date_create($row['datacad']), 'd/m/Y') . "
        </td>
        <td class='text-left' width='200px'> $acao </td>
    </tr>";
}

$dados .= "</tbody>
	</table>
</div>";

echo $dados;
// close connection
$database->closeConection();
// echo json_encode($output);
