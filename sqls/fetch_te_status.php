<?php
$output = array('error' => false);
require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataSource.php';

use Dsource\DataSource;

$database = new DataSource();
$output = array('error' => false);

$sql0 = "SELECT count(*) as `total_count`, `status_insc` FROM `te_inscricao`";
$resultConf = $database->selectArray($sql0);
if (!empty($resultConf)) {
	$output['total_count'] = $resultConf[0]['total_count'];
}

$sql01 = "SELECT count(*) as `confirmado_pago`, `status_insc` FROM `te_inscricao` WHERE `status_insc` = 'Confirmado'";
$resultConf1 = $database->selectArray($sql01);
if (!empty($resultConf1)) {
	$output['confirmado_pago'] = $resultConf1[0]['confirmado_pago'];
}

$sql05 = "SELECT count(*) as `confirmado_isento`, `status_insc` FROM `te_inscricao` WHERE `status_insc` = 'Isento'";
$resultConf5 = $database->selectArray($sql05);
if (!empty($resultConf5)) {
	$output['confirmado_isento'] = $resultConf5[0]['confirmado_isento'];
}

$sql02 = "SELECT count(*) as `cancelado_count`, `status_insc` FROM `te_inscricao` WHERE `status_insc` = 'cancelado'";
$resultConf2 = $database->selectArray($sql02);
if (!empty($resultConf2)) {
	$output['cancelado_count'] = $resultConf2[0]['cancelado_count'];
}

$sql03 = "SELECT count(*) as `null_count`, `status_insc` FROM `te_inscricao` WHERE `status_insc` is null";
$resultConf3 = $database->selectArray($sql03);
if (!empty($resultConf3)) {
	$output['null_count'] = $resultConf3[0]['null_count'];
}
// close connection
$database->closeConection();
echo json_encode($output);
// echo json_encode($chartData);