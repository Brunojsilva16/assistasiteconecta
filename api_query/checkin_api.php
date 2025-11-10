<?php

/**
 * Endpoint de API para processamento de Check-in.
 *
 * Este script recebe um token de ingresso e uma chave de API,
 * valida as informações, interage com o banco de dados e
 * retorna um resultado padronizado em formato JSON.
 */

// Garante que o caminho para o dataSource seja robusto, partindo do diretório atual.
require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataSource.php';

use Dsource\DataSource;

// --- CONFIGURAÇÃO DE SEGURANÇA ---
define('SECRET_API_KEY', 'Ch4v3-P4r4-Meu-Ev3nt0-Te-2025!');

// --- RESPOSTA PADRÃO ---
// Garante que a saída seja sempre JSON e com o charset correto.
header('Content-Type: application/json; charset=utf-8');

// echo json_encode($_GET);

/**
 * Envia uma resposta JSON padronizada e encerra o script.
 *
 * @param int $statusCode O código de status HTTP (200, 401, 404, etc.).
 * @param string $status 'success', 'error', ou 'info'.
 * @param string $message A mensagem para o usuário final.
 * @param array $data Dados adicionais a serem incluídos na resposta.
 */
function send_json_response($statusCode, $status, $message, $data = [])
{
    http_response_code($statusCode);
    $response = ['status' => $status, 'message' => $message];
    if (!empty($data)) {
        $response = array_merge($response, $data);
    }
    echo json_encode($response);
    exit;
}

// --- LÓGICA DE VALIDAÇÃO DA REQUISIÇÃO ---

// 1. Verificação da Chave de API
$submittedApiKey = $_GET['apiKey'] ?? null;
if ($submittedApiKey !== SECRET_API_KEY) {
    send_json_response(401, 'error', 'Acesso não autorizado.');
}

// 2. Obtenção e Validação do Token do Ingresso
$idtoken = $_GET['idtoken'] ?? null;
if (empty($idtoken)) {
    send_json_response(400, 'error', 'Token do ingresso não fornecido.');
}

// 3. Verificação da tabela
$apiTable = $_GET['apiTable'] ?? null;
if (empty($apiTable)) {
    send_json_response(400, 'error', 'Token do ingresso não fornecido.');
}
// --- LÓGICA DE NEGÓCIO (INTERAÇÃO COM O BANCO DE DADOS) ---

try {
    $database = new DataSource();

    // Busca o participante pelo token para verificar seu status.
    $sql = "SELECT * FROM `$apiTable` WHERE id_insc = ?";
    $paramValue = array(
        $idtoken
    );

    $result = $database->select($sql, $paramValue);

    if (!$result) {
        send_json_response(404, 'error', 'Participante não encontrado.');
    }

    $nome = $result['nomecracha_insc'];
    $email = $result['email_insc'];

    // Verifica se o check-in já foi realizado.
    if ($result['check_in'] > 0) {
        // HTTP 409 Conflict é adequado para uma ação que não pode ser repetida.
        send_json_response(409, 'info', "Check-in já realizado para: {$nome}.");
    }

    // Se chegou até aqui, o participante existe e ainda não fez check-in.
    // Adiciona a data/hora atual ao fazer o check-in (boa prática).
    $sql_update = "UPDATE `$apiTable` SET check_in = 1, data_checkin = NOW() WHERE id_insc = ?";
    $params = [
        $idtoken,
    ];

    $update_result = $database->update($sql_update, $params);

    if ($update_result > 0) {
        // Sucesso! Retorna os dados do participante.
        send_json_response(200, 'success', "Check-in de {$nome} realizado com sucesso!", ['nome' => $nome, 'email' => $email]);
    } else {
        // Se a atualização falhar por algum motivo inesperado.
        send_json_response(500, 'error', 'Falha ao registrar o check-in no banco de dados.');
    }
} catch (Exception $e) {
    // Captura qualquer erro de conexão ou de consulta SQL.
    // Em um ambiente de produção, é bom logar o erro em um arquivo.
    // error_log($e->getMessage());
    send_json_response(500, 'error', 'Erro interno do servidor. Não foi possível conectar ao banco de dados.');
}
