<?php

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'NewdataSource.php';

use Dsource\DataSource;

$database = new DataSource();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

// =========================================================================
// Lógica para VERIFICAÇÃO (Passo 1: E-MAIL) - Usando método GET
// =========================================================================
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['email'])) {
    $email = trim($_GET['email']);

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "E-mail inválido."]);
        exit;
    }

    // ALTERAÇÃO 1: Adicionado o campo 'concluiu_quiz' na consulta
    $sqlCheck = "SELECT id, nome, concluiu_quiz FROM participante_quiz WHERE email = ?";
    $paramCheck = array($email);
    $participante = $database->select($sqlCheck, $paramCheck);

    if ($participante) {
        // ALTERAÇÃO 2: Nova verificação para quem já concluiu
        if ($participante['concluiu_quiz'] == 1) {
            // Se 'concluiu_quiz' for TRUE (ou 1), retorna um novo status
            echo json_encode(["status" => "completed", "message" => "Este participante já concluiu o quiz."]);
        } else {
            // Se existe mas não concluiu, o fluxo continua normal
            $_SESSION['participante_id'] = $participante['id'];
            echo json_encode(["status" => "exists", "participante_nome" => $participante['nome']]);
        }
    } else {
        // Participante não encontrado, fluxo normal de cadastro
        echo json_encode(["status" => "new"]);
    }
    exit;
}

// =========================================================================
// Lógica para CADASTRO (Passo 2: NOME/TELEFONE) - Usando método POST
// =========================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $nome = $data['nome'] ?? '';
    $email = $data['email'] ?? '';
    $telefone = $data['telefone'] ?? '';

    if (empty($nome) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($telefone)) {
        echo json_encode(["success" => false, "message" => "Todos os campos são obrigatórios."]);
        exit;
    }

    $sqlInsert = "INSERT INTO participante_quiz (nome, email, telefone) VALUES (?,?,?)";
    $paramInsert = array($nome, $email, $telefone);
    $rowCount = $database->insert($sqlInsert, $paramInsert);

    if ($rowCount > 0) {
        $lastId = $database->getConnection()->lastInsertId();
        $_SESSION['participante_id'] = $lastId;
        echo json_encode(["success" => true, "message" => "Cadastro realizado com sucesso!", "id" => $lastId]);
    } else {
        echo json_encode(["success" => false, "message" => "Erro ao cadastrar. O e-mail pode já estar em uso."]);
    }
    exit;
}

echo json_encode(["status" => "error", "message" => "Requisição inválida."]);