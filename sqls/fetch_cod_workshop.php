<?php

$output = array('error' => false);

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataSource.php';

use Dsource\DataSource;

$database = new DataSource();

$output = array('error' => false);


$sql = "SELECT * FROM codigo WHERE porcent_cod in (15, 40) AND codigo_cod = ?";
$paramValue = array(
	$_POST["cupompc"]
);

$result = $database->select($sql, $paramValue);

if ($result > 0) {

	// $valor = ($_POST['val'] * $result['porcent_cod'] / 100);
    // $valorFinal = $_POST['val'] - $valor;

	$output['porcento'] = $result['porcent_cod'];
	$output['data'] = $result;
	$output['message'] = 'Successfully';
} else {
	$output['error'] = true;
	$output['message'] = 'Cupom inválido!';
}

// close connection
$database->closeConection();
echo json_encode($output);
