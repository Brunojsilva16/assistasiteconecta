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
	<th class='text-center'>Categoria</th>
	<th class='text-center'>Telefone</th>
	<th class='text-center'>Cupom</th>
	<th class='text-center'>Status</th>
	<th class='text-center'>Data</th>

</thead>
<tbody";

// echo $dados;

$sql = "SELECT * FROM `te_inscricao` WHERE status_insc is null ORDER BY `datacad` DESC";
$resultConut = $database->selectFetchAll($sql);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$inicio = 0;
$numero = $inicio;
while ($row = $resultConut->fetch(PDO::FETCH_ASSOC)) {
    $numero++;

    $botao_conf = '<button type="button" onclick="get_param(this);" class="btn btn-outline-success" data-p="1" data-v="Confirmado" title="confirmar" data-id="' . $row['id_insc'] . '"><i class="fas fa-solid fa-check"></i></button>';
    $botao_isent = '<button type="button" onclick="get_param(this);" class="btn btn-outline-info" data-p="1" data-v="Isento" title="Isentar" data-id="' . $row['id_insc'] . '"><i class="fa-solid fa-pen"></i></button>';
    $botao_canc = '<button type="button" onclick="get_param(this);" class="btn btn-outline-warning" data-p="1" data-v="Cancelado" title="Cancelar" data-id="' . $row['id_insc'] . '"><i class="fas fa-times" aria-hidden="true"></i></button>';
    $botao_del = '<button type="button" onclick="get_delete(this);" class="btn btn-outline-danger" data-page="im_inscricao" data-bd="inscricao" data-idbd="id_insc" data-id="' . $row['id_insc'] . '"><i class="fa-solid fa-trash"></i></button>';

    // $acao = '';

    // if ($_SESSION['nivel_accesso'] > 3) {

    //     switch ($row['status_insc']) {
    //         case 'Confirmado':
    //             $acao = $botao_isent . ' ' . $botao_canc . ' ' . $botao_del;
    //             break;
    //         case 'Cancelado':
    //             $acao = $botao_conf . ' ' . $botao_isent . ' ' . $botao_del;
    //             break;
    //         case 'Isento':
    //             $acao = $botao_conf . ' ' . $botao_canc . ' ' . $botao_del;
    //             break;
    //         case '':
    //             $acao = $botao_conf . ' ' . $botao_canc . ' ' . $botao_isent . ' ' .  $botao_del;
    //             break;

    //         default:
    //             $acao;
    //             break;
    //     }
    // } else {
    //     switch ($row['status_insc']) {
    //         case 'Confirmado':
    //             $acao = $botao_isent . ' ' . $botao_canc;
    //             break;
    //         case 'Cancelado':
    //             $acao = $botao_conf . ' ' . $botao_isent;
    //             break;
    //         case 'Isento':
    //             $acao = $botao_conf . ' ' . $botao_canc;
    //             break;
    //         case '':
    //             $acao = $botao_conf . ' ' . $botao_canc . ' ' . $botao_isent;
    //             break;

    //         default:
    //             $acao;
    //             break;
    //     }
    // }

    $dados .=  "<tr>
		<td class='text-center' width='70px'>" . $numero . "</td>
		<td class='text-left' width='260px'>" . $row['nome_insc'] . "</td>
		<td class='text-center' width='120px'>" . $row['categoria_insc'] . "</td>
		<td class='text-left' width='160px'>" . $row['telefone_insc'] . "</td>
		<td class='text-center' width='180px'>" . $row['cupom_insc'] . "</td>
		<td class='text-left' width='14px'>" . 'Pendentes' . "</td>

		<td class='text-center' max-width='125px'>
			" . date_format(date_create($row['datacad']), 'd/m/Y') . "
		</td>

	</tr>";
}

$dados .= "</tbody>
	</table>
</div>";

echo $dados;
// close connection
$database->closeConection();
// echo json_encode($output);
