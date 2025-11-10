<?php

use LoginstatusMaster\LoginM;

$output = array('error' => false);

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataLoginM.php';

$mail = $_POST['conecta_email'];
$senha = $_POST['conecta_senha'];
$nivel = $_POST['conecta_acesso'];


$login = new LoginM();

$result = $login->authenticateMember($mail, $senha, $nivel, "SELECT * FROM usuarios_a where email = ?");

if ($result['result'] != false) {

    $output['message'] = $result['mensagem'];
} else {
    $output['error'] =  true;
    $output['message'] = $result['mensagem'];

}

echo json_encode($output);