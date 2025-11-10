<?php

$output = array('error' => false);

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataSource.php';

use Dsource\DataSource;

$database = new DataSource();

$output = array('error' => false);

// "<pre>";
// echo print_r($_POST);
// // echo $datacad;
// "</pre>";
// $output['post'] = print_r($_POST);
// // exit;

$sql = "SELECT * FROM codigo WHERE codigo_cod = ?";
$paramValue = array(
	$_POST["cupompc"]
);

$result = $database->select($sql, $paramValue);
// "<pre>";
// echo print_r($result);
// // echo $datacad;
// "</pre>";


if ($result > 0) {

	// $valor = ($_POST['val'] * $result['porcent_cod'] / 100);
    // $valorFinal = $_POST['val'] - $valor;

	// $output['final'] = $valorFinal;
	$output['data'] = $result;
	$output['message'] = 'Successfully';
} else {
	$output['error'] = true;
	$output['message'] = 'Cupom inválido!';
}

// close connection
$database->closeConection();
echo json_encode($output);
