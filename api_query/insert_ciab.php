<?php

$output = array('error' => false);

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'NewdataSource.php';

use Dsource\DataSource;

$database = new DataSource();

$email = $_POST["email"];
$whatsapp = $_POST["whatsapp"];

// Passo 1: Verificar se o e-mail ou WhatsApp já existem
$sqlCheck = "SELECT id FROM participantes WHERE email = ? OR whatsapp = ?";
$paramCheck = array($email, $whatsapp);
$existingUser = $database->select($sqlCheck, $paramCheck); // Usando o método select()

// Passo 2: Se o usuário existir, preparar uma resposta de erro específica
if ($existingUser) {
    $output['error'] = true;
    $output['exists'] = true; // Flag para o frontend identificar o tipo de erro
    $output['message'] = 'Já existe um cadastro com este E-mail ou WhatsApp!';
} else {
    // Passo 3: Se não existir, prosseguir com a inserção
    $sqlInsert = "INSERT INTO participantes(nome, email, whatsapp) VALUES (?,?,?)";
    $paramInsert = array(
        $_POST["nome"],
        $email,
        $whatsapp
    );

    $result = $database->insert($sqlInsert, $paramInsert); // Usando o método insert()

    if ($result > 0) {
        $output['success'] = true;
        $output['error'] = false;
        $output['message'] = 'Cadastro realizado com sucesso, Boa sorte!';
    } else {
        $output['error'] = true;
        $output['message'] = 'Problema em adicionar os dados. Tente novamente!';
    }
}

$database->closeConection();
header('Content-Type: application/json');
echo json_encode($output);

?>