<?php

$output = array('error' => false);

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataSource.php';

use Dsource\DataSource;

$database = new DataSource();

$output = array('error' => false);

date_default_timezone_set('America/Sao_Paulo');
$datacad = date("Y-m-d H:i:h");

// "<pre>";
// echo print_r($_POST);
// echo $datacad;
// "</pre>";

// $output['post'] = print_r($_POST);
// exit;

$sql = "INSERT INTO grupo(nome_in, cpf_in, email_in, telefone_in, codigo_in, valor_in, datacad) VALUES (?,?,?,?,?,?,?)";
$paramValue = array(
    $_POST["nomecad"],
    $_POST["cpfcad"],
    $_POST["emailcad"],
    $_POST["fonecad"],
    $_POST["organ_grupo"],
    $_POST["lote_select"],
    $datacad
);

$result = $database->insert($sql, $paramValue);

if ($result > 0) {
    $output['message'] = 'Dado adicionado com sucesso!';
} else {
    $output['error'] = true;
    $output['message'] = 'Problema em adicionar os dados. Tente novamente!';
}

$database->closeConection();
echo json_encode($output);
