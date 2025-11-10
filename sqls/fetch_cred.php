<?php

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataSource.php';

use Dsource\DataSource;

$database = new DataSource();

$output = array('error' => false);
$output['email'] = false;

$id = $_POST["idch"];

$sql = "SELECT * FROM inscricao WHERE id_insc = ?";
$paramValue = array(
    $id
);

$result = $database->select($sql, $paramValue);
// "<pre>";
// echo print_r($result);
// // echo $datacad;
// "</pre>";


if ($result > 0) {

    if ($result['check_in'] > 0) {

        $output['message'] = 'Check-in já realizado!';
        $output['name'] = $result['nome_insc'];
        // $output['email'] = $result['email_insc'];
        $output['envio'] = false;
        
    } else {
        $sqltwo = "UPDATE inscricao SET check_in = ? WHERE id_insc = ?";
        $paramValuetwo = array(
            1,
            $id
        );
        $resulttwo = $database->update($sqltwo, $paramValuetwo);
        
        if ($resulttwo > 0) {
            
            $output['envio'] = true;
            $output['message'] = 'Check-in realizado com sucesso!';
            $output['nome'] = $result['nome_insc']; 
            $output['email'] = $result['email_insc'];

        } else {

            $output['error'] = true;
            $output['message'] = 'Dados Inválidos!';
            $output['nome'] = $result['nome_insc']; 
            $output['email'] = $result['email_insc'];
        }
    }
}else{
    $output['error'] = true;
    $output['message'] = 'Participante não encontrado!';
}

// close connection
$database->closeConection();
echo json_encode($output);