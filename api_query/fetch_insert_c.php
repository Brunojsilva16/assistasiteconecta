<?php

$output = array('error' => false);

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataSource.php';

use Dsource\DataSource;

$database = new DataSource();

$output = array('error' => false);

$action = $_POST['action'] ?? '';

date_default_timezone_set('America/Sao_Paulo');
$datacad = date("Y-m-d H:i:h");

if ($action != 'save_user') {

    $output['message'] = 'Dados de entrada inválidos ou ausentes.';
    // Interrompe a execução e envia a resposta de erro.
    http_response_code(400); // Bad Request
    echo json_encode($output);
    exit;
} else {

    $sql = "INSERT INTO colonia_te(nome_insc, responsavel_insc, cpf_insc, email_insc, telefone_insc, categoria_insc, valor_insc, datacad) 
    VALUES (?,?,?,?,?,?,?,?)";
    $paramValue = array(
        $_POST["nome"],
        $_POST["responsavel"],
        $_POST["cpf"],
        $_POST["email"],
        $_POST["telefone"],
        $_POST["modalidade"],
        $_POST["valor"],
        $datacad
    );

    $result = $database->insertLastID($sql, $paramValue);

    if ($result > 0) {
        $output['status'] = 'success';
        // $outpu['mod'] = $_POST["mod-select"];
        // $outpu['vall'] = $_POST["lote-select"];
    } else {
        $output['error'] = true;
        $output['message'] = 'Problema em adicionar os dados. Tente novamente!';
    }
}

$database->closeConection();
echo json_encode($output);
