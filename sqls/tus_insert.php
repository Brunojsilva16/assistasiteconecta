<?php

$output = array('error' => false);

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataSource.php';

use Dsource\DataSource;

$database = new DataSource();

$output = array('error' => false);

date_default_timezone_set('America/Sao_Paulo');
$datacad = date("Y-m-d H:i:h");

$sql = "INSERT INTO workshop_tus(nome_insc, cpf_insc, email_insc, telefone_insc, valor_insc, datacad) VALUES (?,?,?,?,?,?)";
$paramValue = array(
    $_POST["nomecad"],
    $_POST["cpfcad"],
    $_POST["emailcad"],
    $_POST["fonecad"],
    $_POST["lote_select"],
    $datacad
);

$result = $database->insertLastID($sql, $paramValue);

if ($result > 0) {
    $output['id_participante'] = $result;
    // $outpu['mod'] = $_POST["mod-select"];
    // $outpu['vall'] = $_POST["lote-select"];
} else {
    $output['error'] = true;
    $output['message'] = 'Problema em adicionar os dados. Tente novamente!';
}

$database->closeConection();
echo json_encode($output);
