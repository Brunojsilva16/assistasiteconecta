<?php

$output = array('error' => false);

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataSource.php';

use Dsource\DataSource;

$database = new DataSource();

$output = array('error' => false);

$sql = "UPDATE papo SET status_insc = ? WHERE id_insc = ?";
$paramValue = array(
    $_POST["status"],
    $_POST["codparceiro"]
);

$result = $database->update($sql, $paramValue);

if ($result > 0) {
    $output['error'] = false;

} else {
    $output['error'] = true;
    // $output['message'] = 'Problema em adicionar os dados. Tente novamente!';
}

$database->closeConection();
echo json_encode($output);