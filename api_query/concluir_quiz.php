<?php

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'NewdataSource.php';

use Dsource\DataSource;

// Inicia o objeto do banco de dados que já gerencia a conexão
$database = new DataSource();

// Garante que a sessão está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

// 1. Verifica se o ID do participante está na sessão
$participante_id = $_SESSION['participante_id'] ?? null;

if (!$participante_id) {
    // Envia uma resposta de erro se não encontrar o ID
    echo json_encode(["success" => false, "message" => "ID do participante não encontrado na sessão."]);
    exit; // Para a execução do script
}

// 2. Prepara e executa a atualização usando a classe DataSource
$sql = "UPDATE participante_quiz SET concluiu_quiz = TRUE WHERE id = ?";
$paramValue = array(
    $participante_id
);

// O método update() retorna o número de linhas afetadas
$affectedRows = $database->update($sql, $paramValue);

// 3. Verifica o resultado
if ($affectedRows > 0) {
    // Se uma ou mais linhas foram atualizadas, a operação foi um sucesso
    echo json_encode(["success" => true, "message" => "Status de conclusão salvo com sucesso."]);
    
    // Opcional: Limpar a sessão APENAS se a atualização for bem-sucedida
    unset($_SESSION['participante_id']);

} else {
    // Se nenhuma linha foi afetada, pode ser que o ID não exista ou já estava com o valor TRUE.
    // Você também pode adicionar uma verificação aqui para ter certeza que o participante existe.
    echo json_encode(["success" => false, "message" => "Nenhuma alteração foi realizada. O participante pode não existir ou o status já estava salvo."]);
}

// Não é necessário fechar a conexão manualmente aqui, pois o objeto DataSource cuida disso quando o script termina.
exit;
?>