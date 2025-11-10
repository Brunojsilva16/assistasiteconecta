<?php

// Ajuste o caminho conforme a estrutura do seu projeto.
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'NewdataSource.php';

use Dsource\DataSource;

// Define o cabeçalho como JSON desde o início para garantir a saída correta
header('Content-Type: application/json');

try {
    $ds = new DataSource();

    // quantidade de perguntas por nível
    $nivelPerguntas = [
        'facil' => 3,
        'medio' => 3,
        'dificil' => 4
    ];

    $perguntasSelecionadas = [];

    // O loop vai buscar as perguntas na ordem definida no array: primeiro fáceis, depois médias, depois difíceis.
    foreach ($nivelPerguntas as $nivel => $qtd) {

        $query = "SELECT * FROM perguntas WHERE nivel = :nivel ORDER BY RAND() LIMIT :qtd";
        
        // CORREÇÃO: Passando parâmetros como um array associativo
        // A chave do array deve corresponder ao placeholder na query (ex: ':nivel')
        $params = [
            ':nivel' => $nivel,
            ':qtd' => $qtd
        ];

        $perguntasDoNivel = $ds->selectQuiz($query, $params);
        $perguntasSelecionadas = array_merge($perguntasSelecionadas, $perguntasDoNivel);
    }

    // REMOVIDO: A linha shuffle() que embaralhava a ordem final das 10 perguntas foi removida.
    // Agora, a ordem será sempre 3 fáceis, 3 médias e 4 difíceis.
    // shuffle($perguntasSelecionadas);

    echo json_encode($perguntasSelecionadas);

} catch (Exception $e) {
    // Captura qualquer erro inesperado e retorna uma mensagem de erro em JSON
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => true, 'message' => 'Ocorreu um erro no servidor: ' . $e->getMessage()]);
}
