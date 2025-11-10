<?php

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataSource.php';

use Dsource\DataSource;

$database = new DataSource();

$output = array('error' => false);
// $output['geralpost'] = print_r($_POST);

$banco = $_POST['banco'];
$idbanco = $_POST['idbanco'];
$idreg = $_POST['idreg'];


$sql = "DELETE FROM $banco WHERE $idbanco=?";
$paramValue = array(
    intval($idreg)
);

$result = $database->delete($sql, $paramValue);

if ($result > 0) {
    $output['message'] = 'Registro excluído com sucesso!';
} else {
    $output['error'] = true;
    $output['message'] = "problem in delete! Please Retry!";
}

$database->closeConection();
echo json_encode($output);
