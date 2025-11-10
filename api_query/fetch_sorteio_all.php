<?php

header('Content-Type: application/json; charset=utf-8');

// Ajuste o caminho conforme a estrutura do seu projeto.
// Ex: se a pasta 'api_query' e 'classes' estão na raiz.
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'NewdataSource.php';

use Dsource\DataSource;

$ds = new DataSource();

// Ação de Sortear
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'sortear') {
    try {
        $sql = "SELECT id, nome, whatsapp FROM `participantes` WHERE `sorteado` = FALSE ORDER BY RAND() LIMIT 1";
        $participante = $ds->select($sql);

        if ($participante) {
            $idVencedor = $participante['id'];
            $updateSql = "UPDATE `participantes` SET `sorteado` = TRUE WHERE `id` = :id";
            $ds->update($updateSql, [':id' => $idVencedor]);

            echo json_encode(['success' => true, 'nomeSorteado' => $participante['nome'], 'telefone' => $participante['whatsapp']]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Todos os participantes já foram sorteados!']);
        }
    } catch (\PDOException $e) {
        error_log($e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Erro no servidor ao tentar realizar o sorteio.']);
    }
}
// Ação de Resetar o Sorteio
else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'resetar') {
    try {
        $resetSql = "UPDATE `participantes` SET `sorteado` = FALSE";
        $ds->update($resetSql);

        echo json_encode(['success' => true, 'message' => 'Sorteio reiniciado com sucesso!']);
    } catch (\PDOException $e) {
        error_log($e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Erro ao reiniciar o sorteio.']);
    }
}
// Ação de Obter a Lista de Participantes
else if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_participants') {
    try {
        $sql = "SELECT nome FROM `participantes` ORDER BY nome ASC";
        $participantesData = $ds->selectAll($sql);
        
        // O método selectAll retorna um array de arrays. Usamos array_column para extrair apenas os nomes.
        $participantes = array_column($participantesData, 'nome');
        
        echo json_encode(['success' => true, 'participantes' => $participantes]);
    } catch (\PDOException $e) {
        error_log($e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Erro ao buscar participantes.']);
    }
}
// Requisição Inválida
else {
    http_response_code(400);
    echo json_encode(['error' => 'Requisição inválida.']);
}
