<?php

$output = array('error' => false);

// Define o tipo de conteúdo da resposta como JSON
header('Content-Type: application/json');

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataSource.php';

use Dsource\DataSource;

$database = new DataSource();

$output = array('error' => false);

$nomeTabela = trim($_POST['nomeTabela']);

$sql = "UPDATE $nomeTabela SET check_in_email = ? WHERE id_insc = ?";
$paramValue = array(
    1,
    $_POST["id"]
);

$result = $database->update($sql, $paramValue);

if ($result > 0) {
    $output['success'] = true;
    $output['error'] = false;
} else {
    $output['success'] = false;
    $output['error'] = true;
    $output['message'] = 'Problema em adicionar os dados. Tente novamente!';
}

$database->closeConection();
echo json_encode($output);
