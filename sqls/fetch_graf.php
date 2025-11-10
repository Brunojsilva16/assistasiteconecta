<?php

$output = array('error' => false);

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataSource.php';

use Dsource\DataSource;

$database = new DataSource();

$output = array('error' => false);

$sql = "SELECT count(*) as insc_count, categoria_insc FROM inscricao GROUP BY categoria_insc";
$result = $database->selectFetchAll($sql);


while ($rowcf = $result->fetch(PDO::FETCH_ASSOC)) {
	// $resultset[] = $row;
	$labelconf[] = $rowcf["insc_count"];
	$countconf[] = $rowcf["categoria_insc"];
	// $numero++;
	// $totalconf += $rowcf["status_insc_count"];
}

$output['valor'] = $labelconf;
$output['categoria'] = $countconf;

// close connection
$database->closeConection();
echo json_encode($output);
// echo json_encode($chartData);
