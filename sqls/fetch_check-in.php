<?php

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

$_POST["password"];
$id = 8;

$sql = "SELECT * FROM credenciador WHERE id_user = ?";
$paramValue = array(
	$id
);

$result = $database->select($sql, $paramValue);
// "<pre>";
// echo print_r($result);
// // echo $datacad;
// "</pre>";

if ($result > 0) {

	$senha = $_POST["password"];
	$senharow = $result['senha'];

	if (password_verify($senha, $senharow)) {
		$output['error'] = false;
		$output['valor'] = true;
	}else{
		$output['error'] = true;
		$output['valor'] = false;
		$output['message'] = 'Senha incorreta!';
	}
} else {
	$output['error'] = true;
	$output['message'] = 'Dados Inválidos!';
}

// close connection
$database->closeConection();
echo json_encode($output);
