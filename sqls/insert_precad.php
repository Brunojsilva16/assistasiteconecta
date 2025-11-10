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


$sql = "INSERT INTO evento(nome_ev, email_ev, telefone_ev, datacad) VALUES (?,?,?,?)";
$paramValue = array(
    $_POST["nome"],
    $_POST["email"],
    $_POST["telefone"],
    $datacad
);

$result = $database->insert($sql, $paramValue);

if ($result > 0) {
    $output['message'] = 'Dado adicionado com sucesso!';
} else {
    $output['error'] = true;
    $output['message'] = 'Problema em adicionar os dados. Tente novamente';
}

$database->closeConection();
echo json_encode($output);
?>
