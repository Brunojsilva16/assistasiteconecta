<?php

$output = array('error' => false);

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataSource.php';

use Dsource\DataSource;

$database = new DataSource();

$output = array('error' => false);

date_default_timezone_set('America/Sao_Paulo');
$datacad = date("Y-m-d H:i:h");

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

$sql = "INSERT INTO inscricao(nome_insc, cpf_insc, email_insc, telefone_insc, categoria_insc, valor_insc, nomecracha_insc, doc_insc, datacad) VALUES (?,?,?,?,?,?,?,?,?)";
$paramValue = array(
    $_POST["nomecad"],
    $_POST["cpfcad"],
    $_POST["emailcad"],
    $_POST["fonecad"],
    $_POST["mod_select"],
    $_POST["lote_select"],
    $_POST["nomecracha"],
    $new_filenameDoc,
    $datacad
);

$result = $database->insertLastID($sql, $paramValue);

if ($result > 0) {
    $output['id_participante'] = $result;
    // $outpu['mod'] = $_POST["mod-select"];
    // $outpu['vall'] = $_POST["lote-select"];
} else {
    $output['error'] = true;
    $output['message'] = 'Problema em adicionar os dados. Tente novamente!';
}

$database->closeConection();
echo json_encode($output);
