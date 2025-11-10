<?php
// api.php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// --- Configurações do Banco de Dados ---
$dbConfig = [
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'name' => 'test'
];

// --- Configuração de Permissões por Tabela ---
// Mapeia o nome da tabela para o requisito de acesso.
// Pode ser um INTEIRO (nível de acesso mínimo) ou uma STRING (nome do papel requerido).
$permissoesTabelas = [
    'inscricao_workshop' => 3,                     // Nível de acesso 3 ou superior
    'financeiro' => 5,                 // Nível de acesso 5 (admin máximo)
    'gerenciamento_usuarios' => 4,                 // Nível de acesso 4 ou superior
    'inscricao' => 1,                              // Nível de acesso 1 ou superior (qualquer usuário logado)
    'te_experience' => 'Experience',      // Requer o papel 'palestrante'
    'colaborador_interno' => 'colaborador',
    'ferramentas_moderador' => 'moderador',        // Requer o papel 'moderador'
    // 'area_vip_evento' => ['nivel' => 2, 'papel' => 'vip'], // Exemplo mais complexo: Nível 2 OU papel 'vip' (ver na função)
    // 'outra_tabela_sensivel' => 5,
];

$tabelaSelecionada = isset($_GET['tabela']) ? trim($_GET['tabela']) : 'inscricao';
$filtroSelecionado = isset($_GET['filtro']) ? trim($_GET['filtro']) : 'inscricoes-todas';

function enviarRespostaJson($data, int $statusCode = 200): void
{
    header('Content-Type: application/json');
    http_response_code($statusCode);
    echo json_encode($data);
    exit;
}

// --- Funções Auxiliares ---
function conectarDb(array $config): ?mysqli
{
    $conn = new mysqli($config['host'], $config['user'], $config['pass'], $config['name']);
    if ($conn->connect_error) {
        enviarRespostaJson(['error' => "Erro de conexão com o banco de dados: " . $conn->connect_error], 500);
        return null;
    }
    $conn->set_charset("utf8mb4");
    return $conn;
}


$tituloPagina = 'Página teste';
$records = ['casa', 'arroz', 'feijão'];

enviarRespostaJson(['title' => $tituloPagina, 'records' => $records]);


function validarNomeTabela(string $tabela, array $tabelasPermitidasGlobalmente): bool
{
    if (!in_array($tabela, $tabelasPermitidasGlobalmente)) {
        enviarRespostaJson(['error' => "Recurso de tabela inválido ou não encontrado: {$tabela}"], 400);
        return false;
    }
    return true;
}

/**
 * Verifica se o usuário tem permissão para acessar uma tabela específica.
 * @param string $tabela Tabela que o usuário está tentando acessar.
 * @param array $permissoesConfig Array de configuração (nome_tabela => requisito).
 * Requisito pode ser int (nível) ou string (papel) ou array (complexo).
 * @return void Encerra o script com erro JSON se não tiver permissão.
 */
function verificarPermissaoAcessoTabela(string $tabela, array $permissoesConfig): void
{
    // Verifica se a tabela solicitada tem uma regra de permissão definida
    if (array_key_exists($tabela, $permissoesConfig)) {
        $requisito = $permissoesConfig[$tabela];

        // 1. Verifica se o usuário está logado (presume-se que 'nivel_acesso' ou 'papeis' só existem se logado)
        // Uma verificação mais robusta poderia ser if (!isset($_SESSION['id_usuario']))
        if (!isset($_SESSION['nivel_acesso']) && !isset($_SESSION['nivel_atuacao'])) {
             enviarRespostaJson(['error' => 'Acesso negado. Usuário não autenticado ou sessão inválida.'], 401);
             exit;
        }

        $temPermissao = false;
        $mensagemErroEspecifica = '';

        // Obtém dados da sessão (com defaults para evitar undefined index notices)
        $nivelAcessoUsuario = isset($_SESSION['nivel_acesso']) ? intval($_SESSION['nivel_acesso']) : 0;
        $papeisUsuario = isset($_SESSION['nivel_atuacao']) ? $_SESSION['nivel_atuacao'] : '';


        if (is_int($requisito) > 0) { // Permissão baseada em NÍVEL
            $nivelMinimoRequerido = $requisito;
            if (!isset($_SESSION['nivel_acesso'])) { // Precisa de nível, mas usuário não tem
                 $mensagemErroEspecifica = "Requer nível de acesso, mas não está definido para o usuário.";
            } elseif ($nivelAcessoUsuario >= $nivelMinimoRequerido) {
                $temPermissao = true;
            } else {
                $mensagemErroEspecifica = "Seu nível ({$nivelAcessoUsuario}) é inferior ao requerido ({$nivelMinimoRequerido}).";
            }
        } elseif (is_string($requisito)) { // Permissão baseada em PAPEL
            $papelRequerido = $requisito;
            if (!isset($_SESSION['nivel_atuacao'])) { // Precisa de papel, mas usuário não tem
                $mensagemErroEspecifica = "Requer papel específico, mas não está definido para o usuário.";
            } elseif (in_array($papelRequerido, $papeisUsuario)) {
                $temPermissao = true;
            } else {
                $mensagemErroEspecifica = "Você não possui o papel requerido ('{$papelRequerido}'). Seus papéis: ".implode(', ',$papeisUsuario);
            }
        } else {
            // Configuração de permissão inválida para esta tabela
            error_log("Configuração de permissão inválida para a tabela '{$tabela}' na API.");
            enviarRespostaJson(['error' => "Erro interno na configuração de permissões."], 500);
            exit;
        }

        if (!$temPermissao) {
            enviarRespostaJson([
                'error' => 'Acesso negado. Permissão insuficiente para este recurso.',
                'detalhe' => $mensagemErroEspecifica,
                'tabela_solicitada' => $tabela
            ], 403); // Forbidden
            exit;
        }
    }
    // Se a tabela não está em $permissoesConfig, considera-se acesso público.
}


function construirCondicoesWhere(string $filtro, string &$tituloPagina): array
{
    $condicoes = [];
    switch ($filtro) {
        case 'inscricoes-todas': 
            break;
        case 'inscricoes-aprovadas':
            $condicoes[] = "status_insc = 'Aprovado'";
            $tituloPagina .= " (Aprovadas)";
            break;
        case 'inscricoes-pendentes':
            $condicoes[] = "status_insc = 'Pendente'";
            $tituloPagina .= " (Pendentes)";
            break;
        case 'inscricoes-checkin':
            $condicoes[] = "check_in = 1";
            $tituloPagina .= " (Check-in Feito)";
            break;
        case 'inscricoes-sorteio':
            $condicoes[] = "sorteio = 'Sim'";
            $tituloPagina .= " (Sorteio Sim)";
            break;
        default: break;
    }
    return $condicoes;
}

// --- Lógica Principal da API ---



$tabelasServidasPelaApi = [
    'inscricao', 'inscricao_workshop', 'relatorios_financeiros',
    'gerenciamento_usuarios', 'conteudo_palestrantes', 'ferramentas_moderador', 'area_vip_evento'
];
if (!validarNomeTabela($tabelaSelecionada, $tabelasServidasPelaApi)) {
    exit;
}

// Agora, $permissoesTabelas é definida globalmente no início do script
verificarPermissaoAcessoTabela($tabelaSelecionada, $permissoesTabelas);

$conn = conectarDb($dbConfig);
if (!$conn) {
    exit;
}

$tituloPagina = "Dados de: " . ucfirst(str_replace('_', ' ', $tabelaSelecionada));
$condicoesWhere = construirCondicoesWhere($filtroSelecionado, $tituloPagina);

// ATENÇÃO: Adapte $colunasSelecionadas e $orderByColumn conforme a tabela
$colunasSelecionadas = "*"; // Padrão para buscar todas as colunas
$orderByColumn = "id"; // Coluna padrão para ordenação, se existir

if ($tabelaSelecionada === 'inscricao' || $tabelaSelecionada === 'inscricao_workshop') {
    $colunasSelecionadas = "id_insc, nome_insc, cpf_insc, email_insc, status_insc, sorteio, valor_insc, categoria_insc, check_in, datacad";
    $orderByColumn = "id_insc";
} elseif ($tabelaSelecionada === 'gerenciamento_usuarios') {
    $colunasSelecionadas = "id, nome, email, nivel_acesso"; // Exemplo
    $orderByColumn = "id";
} elseif ($tabelaSelecionada === 'conteudo_palestrantes') {
    $colunasSelecionadas = "id_conteudo, titulo, descricao, id_palestrante, status_aprovacao"; // Exemplo
    $orderByColumn = "id_conteudo";
}
// Adicione mais 'else if' para outras tabelas e suas colunas específicas

$sql = "SELECT {$colunasSelecionadas} FROM `{$tabelaSelecionada}`";

if (!empty($condicoesWhere) && ($tabelaSelecionada === 'inscricao' || $tabelaSelecionada === 'inscricao_workshop')) {
    // Aplica filtros apenas se forem relevantes para a tabela atual
    $sql .= " WHERE " . implode(" AND ", $condicoesWhere);
}

// Verifica se a coluna de ordenação existe na lista de colunas selecionadas (simplificado)
// Uma verificação mais robusta consultaria o schema da tabela.
$colunasParaVerificar = ($colunasSelecionadas === "*") ? [] : explode(',', str_replace(' ', '', $colunasSelecionadas));
if ($colunasSelecionadas === "*" || in_array($orderByColumn, $colunasParaVerificar) || $orderByColumn === "id") { // Assume 'id' como fallback
    $sql .= " ORDER BY `{$orderByColumn}` DESC LIMIT 100";
} else {
    // Se a coluna de ordenação padrão não for adequada, pode-se omitir ORDER BY ou usar um fallback seguro
    $sql .= " LIMIT 100";
     error_log("Coluna de ordenação '{$orderByColumn}' não encontrada ou não aplicável para tabela '{$tabelaSelecionada}'. Ordenação padrão não aplicada.");
}


$result = $conn->query($sql);
$records = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
    $result->free();
} else {
    error_log("Erro na query SQL: " . $conn->error . " | SQL: " . $sql);
    enviarRespostaJson(['error' => "Ocorreu um erro ao buscar os dados para a tabela '{$tabelaSelecionada}'."], 500);
    $conn->close();
    exit;
}

$conn->close();




?>
