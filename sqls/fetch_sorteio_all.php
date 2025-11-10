<?php

header('Content-Type: application/json');

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataSource.php';

use Dsource\DataSource;

$database = new DataSource();



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'sortear') {
    try {
        // Seleciona um participante aleatoriamente
        $sql = "SELECT nome_insc FROM `inscricao` WHERE `status_insc` = 'Confirmado' OR `status_insc` = 'Isento' ORDER BY RAND() LIMIT 1";
        $resultConut = $database->selectFetchAll($sql);

        $participante = $resultConut->fetch(PDO::FETCH_ASSOC);

        if ($participante) {
            echo json_encode(['success' => true, 'nomeSorteado' => $participante['nome_insc']]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Nenhum participante encontrado.']);
        }
    } catch (\PDOException $e) {
        echo json_encode(['error' => 'Erro ao sortear participante: ' . $e->getMessage()]);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_participants') {
    try {
        // Opcional: Para listar todos os participantes (pode ser útil para depuração)
        $stmt = "SELECT nome_insc FROM `inscricao` WHERE `status_insc` = 'Confirmado' OR `status_insc` = 'Isento' ORDER BY nome_insc ASC";
        $participantes = $database->selectArray($stmt);

        echo json_encode(['success' => true, 'participantes' => $participantes]);
    } catch (\PDOException $e) {
        echo json_encode(['error' => 'Erro ao buscar participantes: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Requisição inválida.']);
}