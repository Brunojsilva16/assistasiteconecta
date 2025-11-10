<?php
// Define o cabeçalho da resposta como JSON
header('Content-Type: application/json');

// Inicializa a resposta padrão
$output = array('status' => 'error', 'message' => 'Ocorreu um erro inesperado.');

// Inclui a classe de conexão
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataSource.php';

use Dsource\DataSource;


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $output['message'] = 'Requisição inválida. Use o método POST.';
    http_response_code(405); // 405 Method Not Allowed
    echo json_encode($output);
    exit();
}

// Bloco de Validação (Seu bloco original já era muito bom, mantido com pequenas melhorias)
if (!isset($_POST["nomeTabela"]) || trim($_POST["nomeTabela"]) === '' || !isset($_POST['tabelasPermitidas']) || trim($_POST['tabelasPermitidas']) === '') {
    $output['message'] = 'Parâmetro "nome_tabela" é obrigatório e não pode ser vazio.';
    http_response_code(400); // 400 Bad Request
    echo json_encode($output);
    exit();
}

$nomeTabela = trim($_POST["nomeTabela"]);
$tabelasPermitidasString = isset($_POST['tabelasPermitidas']) ? trim($_POST['tabelasPermitidas']) : '';


$arrayTabelasPermitidas = explode(',', $tabelasPermitidasString);

// Lista de tabelas permitidas. ESSENCIAL PARA SEGURANÇA.
    // $allowedTables = ['inscricao', 'papo', 'papo_two', 'papo_three', 'te_inscricao', 'workshop', 'workshop_tus'];
if (!in_array($nomeTabela, $arrayTabelasPermitidas)) {
    $output['message'] = "Acesso negado. A tabela '$nomeTabela' não tem permissão para ser consultada.";
    http_response_code(403); // 403 Forbidden
    echo json_encode($output);
    exit();
}


try {
    $database = new DataSource();

    // A query usa backticks (`) para proteger o nome da tabela.
    // É seguro porque a variável $nomeTabela foi validada contra uma whitelist.
    $sql = "
        SELECT
            COUNT(*) AS total_count,
            SUM(CASE WHEN `status_insc` = 'Confirmado' THEN 1 ELSE 0 END) AS confirmado_pago,
            SUM(CASE WHEN `status_insc` = 'Isento' THEN 1 ELSE 0 END) AS confirmado_isento,
            SUM(CASE WHEN `status_insc` = 'cancelado' THEN 1 ELSE 0 END) AS cancelado_count,
            SUM(CASE WHEN `status_insc` IS NULL THEN 1 ELSE 0 END) AS null_count
        FROM `$nomeTabela`";

    $result = $database->selectCount($sql);

    // Verificação de Dados Simplificada
    // Como selectArray agora sempre retorna um array, podemos verificar se ele não está vazio.
    // A query de agregação (COUNT, SUM) sempre retornará UMA linha, mesmo que a tabela esteja vazia.
    // Nessa linha, os valores serão 0 ou NULL. Portanto, a verificação do resultado é mais simples.
    if (!empty($result)) {
        $output = [
            'status' => 'success',
            'message' => 'Consulta realizada com sucesso.',
            'data' => $result[0] // A query sempre retorna um único registro com os totais
        ];
    } else {
        // Este bloco 'else' dificilmente será atingido com esta query,
        // mas é uma boa prática para consultas que podem não retornar nada.
        $output['status'] = 'error';
        $output['message'] = 'A consulta não retornou um resultado válido.';
        http_response_code(500);
    }
} catch (PDOException $e) {
    // Captura erros específicos do PDO
    $output['message'] = "Erro ao executar a consulta. Verifique se a tabela e as colunas existem.";
    error_log("Erro de PDO: " . $e->getMessage()); // Loga o erro real para o desenvolvedor
    http_response_code(500); // 500 Internal Server Error
} catch (Exception $e) {
    // Captura outros erros genéricos
    $output['message'] = "Ocorreu um erro inesperado no servidor.";
    error_log("Erro geral: " . $e->getMessage());
    http_response_code(500);
} finally {
    // Garante que a conexão seja fechada
    if ($database !== null) {
        $database->closeConection();
    }
}

// Envia a resposta final em formato JSON
echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>