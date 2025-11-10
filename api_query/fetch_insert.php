<?php

$output = array('error' => false);

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataSource.php';

use Dsource\DataSource;

$database = new DataSource();

$output = array('error' => false);

$action = $_POST['action'] ?? '';

date_default_timezone_set('America/Sao_Paulo');
$datacad = date("Y-m-d H:i:h");

if (isset($_FILES['docfile']) && $_FILES['docfile']['error'] === UPLOAD_ERR_OK) {

    $folderfoto = '../assets/uploads/';

    $filenameDoc = basename($_FILES['docfile']['name']);

    if (!empty($filenameDoc)) {

        mb_internal_encoding("UTF-8");

        $setstr = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = substr(str_shuffle($setstr), 0, 5);

        $ext = pathinfo($filenameDoc, PATHINFO_EXTENSION);
        $new_filenameDoc = $code . time() . '.' . $ext;
        move_uploaded_file($_FILES['docfile']['tmp_name'], $folderfoto . $new_filenameDoc);
    } else {
        $new_filenameDoc = NULL;
    }
} else {
    $new_filenameDoc = NULL;
}

if ($action != 'save_user') {

    $output['message'] = 'Dados de entrada inválidos ou ausentes.';
    // Interrompe a execução e envia a resposta de erro.
    http_response_code(400); // Bad Request
    echo json_encode($output);
    exit;
} else {


    $sql = "INSERT INTO te_inscricao(nome_insc, cpf_insc, email_insc, telefone_insc, categoria_insc, valor_insc, lote_insc, nomecracha_insc, doc_insc, datacad) 
    VALUES (?,?,?,?,?,?,?,?,?,?)";
    $paramValue = array(
        $_POST["nome"],
        $_POST["cpf"],
        $_POST["email"],
        $_POST["telefone"],
        $_POST["modalidade"],
        $_POST["valor"],
        $_POST["lote"],
        $_POST["cracha"],
        $new_filenameDoc,
        $datacad
    );

    $result = $database->insertLastID($sql, $paramValue);

    if ($result > 0) {
        $output['status'] = 'success';
        $output['id_participante'] = $result;
        // $outpu['mod'] = $_POST["mod-select"];
        // $outpu['vall'] = $_POST["lote-select"];
    } else {
        $output['error'] = true;
        $output['message'] = 'Problema em adicionar os dados. Tente novamente!';
    }
}

$database->closeConection();
echo json_encode($output);
