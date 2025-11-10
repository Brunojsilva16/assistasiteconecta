<?php

// Defina o cabeçalho da resposta como JSON.
header('Content-Type: application/json');

// Define o fuso horário padrão para funções de data e hora
date_default_timezone_set('America/Sao_Paulo');

// Inclui a classe DataSource
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataSource.php';

// Define o namespace para a classe DataSource
use Dsource\DataSource;

// Centralize a configuração da resposta em um único array.
$response = ['status' => '', 'message' => ''];

// --- Validação e Sanitização para PHP 8.1+ ---

// Obtenha o valor bruto do POST. O operador '??' evita erros se a chave não existir.
$raw_tabela = $_POST['tabela'] ?? '';

// Sanitize a string de forma explícita:
//    a) Remova tags HTML e PHP com strip_tags().
//    b) Remova espaços em branco do início e do fim com trim().
$tabela = trim(strip_tags($raw_tabela));

// 3. Valide o ID como um inteiro (este filtro NÃO está depreciado).
$id = filter_input(INPUT_POST, 'codparceiro', FILTER_VALIDATE_INT);

$response['message'] = $tabela;

// 4. Verifique se os dados são válidos após a sanitização/validação.
if (empty($tabela) || $id === false) {
    $response['message'] = 'Dados de entrada inválidos ou ausentes.';
    // Interrompe a execução e envia a resposta de erro.
    http_response_code(400); // Bad Request
    echo json_encode($response);
    exit;
}

try {
    // Cria uma instância da classe DataSource
    $database = new DataSource();

    $sql = "DELETE FROM `$tabela` WHERE id_insc = ?";
    $params = [
        $id
    ];

    $affectedRows = $database->delete($sql, $params);

    if ($affectedRows > 0) {
        $response['status'] = 'success';
        $response['message'] = 'Registro excluído com sucesso!';
    } else {
        $response['message'] = 'Nenhuma alteração foi realizada. O status pode já ser o atual ou a inscrição não foi encontrada.';
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    $response['message'] = 'Ocorreu um erro ao processar sua solicitação. Tente novamente mais tarde.';
    http_response_code(500); // Internal Server Error
} finally {
    if (isset($database)) {
        $database->closeConection();
    }
}

// Envia a resposta final em formato JSON.
echo json_encode($response);