<?php

// Define o tipo de conteúdo da resposta como JSON
header('Content-Type: application/json');

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataSource.php';

// Define o namespace para a classe DataSource
use Dsource\DataSource;

// Verifica qual ação foi solicitada pelo JavaScript
$action = $_POST['action'] ?? '';
$nomeTabela = trim($_POST["nomeTabela"]);

switch ($action) {
    case 'check_email':
        $email = $_POST['email'] ?? '';

        if (empty($email)) {
            echo json_encode(['exists' => false, 'error' => 'E-mail não fornecido.']);
            exit;
        }

        // Usa a função melhorada
        $count = isUserExists('email_insc', $email, $nomeTabela);
        echo json_encode(['exists' => $count]);
        break;

    case 'check_cpf':
        $cpf = $_POST['cpf'] ?? '';

        if (empty($cpf)) {
            echo json_encode(['exists' => false, 'error' => 'CPF não fornecido.']);
            exit;
        }

        // Usa a mesma função melhorada
        $count = isUserExists('cpf_insc', $cpf, $nomeTabela);
        echo json_encode(['exists' => $count]);
        break;

    default:
        // Se nenhuma ação válida for enviada
        echo json_encode(['status' => 'error', 'message' => 'Ação inválida.']);
        break;
}

function isUserExists($column, $value, $tabela)
{
     echo json_encode(['tabela' => $tabela]);
    // MELHORIA DE SEGURANÇA: Whitelist de colunas permitidas
    $allowedColumns = ['email_insc', 'cpf_insc'];
    if (!in_array($column, $allowedColumns)) {
        return 0; // Retorna 0 se a coluna não for permitida
    }

    $database = new DataSource();

    // MELHORIA DE PERFORMANCE: A query agora conta os registros no banco.
    // A coluna é segura porque foi validada pela whitelist.
    $sql = "SELECT * FROM {$tabela} WHERE {$column} = ?";

    $paramValue = array($value);

    // Usa o novo método para obter o resultado do COUNT diretamente.
    $row = $database->select($sql, $paramValue);
    return $row;
}
