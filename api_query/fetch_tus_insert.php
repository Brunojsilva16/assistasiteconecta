<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataSource.php';
use Dsource\DataSource;

// Arquivo de log
$logFile = __DIR__ . "/../logs_insert.txt";
date_default_timezone_set('America/Sao_Paulo');

// Função para registrar logs
function logError($message) {
    global $logFile;
    file_put_contents($logFile, "[".date("Y-m-d H:i:s")."] ".$message.PHP_EOL, FILE_APPEND);
}
$datacad = date("Y-m-d H:i:h");

try {
    $ds = new DataSource();

    // Coleta dados enviados
    $nome     = $_POST['nome']     ?? null;
    $cpf      = $_POST['cpf']      ?? null;
    $email    = $_POST['email']    ?? null;
    $telefone = $_POST['telefone'] ?? null;
    $categoria= $_POST['categoria']?? 'normal';
    $valor    = $_POST['valor']    ?? '0,00';

    // Validação básica
    if (!$nome || !$cpf || !$email || !$telefone) {
        logError("Campos obrigatórios faltando: ".json_encode($_POST));
        echo json_encode([
            "status" => "error",
            "message" => "Campos obrigatórios não preenchidos."
        ]);
        exit;
    }

    // Upload de arquivo (opcional)
    $fileName = null;
    if (!empty($_FILES['docfile']['name'])) {
        $uploadDir = __DIR__ . "/../uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = uniqid() . "_" . basename($_FILES['docfile']['name']);
        $targetFile = $uploadDir . $fileName;

        if (!move_uploaded_file($_FILES['docfile']['tmp_name'], $targetFile)) {
            logError("Falha no upload de arquivo: ".$_FILES['docfile']['name']);
            echo json_encode([
                "status" => "error",
                "message" => "Falha ao salvar arquivo enviado."
            ]);
            exit;
        }
    }

    // Inserção no banco
    $sql = "INSERT INTO workshop_tus (nome_insc, cpf_insc, email_insc, telefone_insc, categoria_insc, valor_insc, doc_insc, datacad) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $params = [$nome, $cpf, $email, $telefone, $categoria, $valor, $fileName, $datacad];

    $id = $ds->insertLastID($sql, $params);

    if ($id) {
        echo json_encode([
            "status" => "success",
            "id_participante" => $id,
            "message" => "Inscrição salva com sucesso!"
        ]);
    } else {
        logError("Insert não retornou ID. Dados: ".json_encode($params));
        echo json_encode([
            "status" => "error",
            "message" => "Não foi possível salvar a inscrição."
        ]);
    }

} catch (Exception $e) {
    logError("Exceção: ".$e->getMessage()." | Trace: ".$e->getTraceAsString());
    echo json_encode([
        "status" => "error",
        "message" => "Erro interno ao salvar inscrição."
    ]);
}
