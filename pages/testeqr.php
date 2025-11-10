<?php
// check-in.php (antigo testeqr.php)

// --- CONFIGURAÇÕES DE SEGURANÇA ---
// Esta chave DEVE ser a mesma do seu aplicativo leitor.
define('SECRET_API_KEY', 'Ch4v3-P4r4-Meu-Ev3nt0-Te-2025!');

// --- CONFIGURAÇÕES DO BANCO DE DADOS ---
$host = 'localhost';
$db   = 'meu_evento';
$user = 'root';
$pass = ''; // Deixe em branco se não houver senha
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Define o cabeçalho da resposta como JSON
header('Content-Type: application/json');

// try {
//     $pdo = new PDO($dsn, $user, $pass, $options);
// } catch (\PDOException $e) {
//     http_response_code(500); // Erro Interno do Servidor
//     echo json_encode(['status' => 'error', 'message' => 'Erro de conexão com o banco de dados.']);
//     exit;
// }

// --- LÓGICA DE VALIDAÇÃO ---

// 1. VERIFICAÇÃO DA CHAVE DE API
// O leitor envia a chave como um parâmetro GET.

// $submittedApiKey = $_GET['apiKey'] ?? null;
// if ($submittedApiKey !== SECRET_API_KEY) {
//     http_response_code(401); // Unauthorized
//     echo json_encode(['status' => 'error', 'message' => 'Acesso não autorizado. Chave inválida.']);
//     exit;
// }

// 2. OBTER O TOKEN DO INGRESSO
// O token vem do QR Code, no parâmetro 'ticket'.
$token = $_GET['idticket'] ?? null;
if (!$token) {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Token do ingresso não fornecido.']);
    exit;
}

// 3. BUSCAR O INGRESSO NO BANCO DE DADOS
$stmt = $pdo->prepare("SELECT * FROM ingressos WHERE token_unico = ?");
$stmt->execute([$token]);
$ingresso = $stmt->fetch();

// 4. VERIFICAÇÃO #1: O INGRESSO EXISTE?
if (!$ingresso) {
    http_response_code(404); // Not Found
    echo json_encode(['status' => 'error', 'message' => 'Ingresso inválido ou não encontrado.']);
    exit;
}

// 5. VERIFICAÇÃO #2: O INGRESSO JÁ FOI UTILIZADO?
if ($ingresso['status'] === 'utilizado') {
    http_response_code(409); // Conflict
    echo json_encode([
        'status' => 'error',
        'message' => 'ATENÇÃO: Ingresso já utilizado em ' . date('d/m/Y H:i:s', strtotime($ingresso['data_checkin'])),
    ]);
    exit;
}

// --- SUCESSO! ---
// Se chegou até aqui, o ingresso é válido.

// 6. ATUALIZAR O STATUS PARA 'UTILIZADO'
$agora = date('Y-m-d H:i:s');
$updateStmt = $pdo->prepare(
    "UPDATE ingressos SET status = 'utilizado', data_checkin = ? WHERE id = ?"
);
$updateStmt->execute([$agora, $ingresso['id']]);

// 7. RETORNAR RESPOSTA DE SUCESSO
http_response_code(200); // OK
echo json_encode([
    'status' => 'success',
    'message' => 'Check-in VÁLIDO! Acesso liberado para ' . $ingresso['nome_comprador'], // Supondo que você tenha essa coluna
]);

?>
