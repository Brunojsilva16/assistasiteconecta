<?php
// É uma boa prática iniciar a sessão no topo do script, antes de qualquer saída HTML.
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
// Define o fuso horário padrão para funções de data e hora
date_default_timezone_set('America/Sao_Paulo');

// Inclui a classe DataSource
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataSource.php';

// Define o namespace para a classe DataSource
use Dsource\DataSource;

// Inicializa a variável que conterá o HTML de saída
$htmlOutput = '';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $output['message'] = 'Requisição inválida. Use o método POST.';
    http_response_code(405); // 405 Method Not Allowed
    echo json_encode($output);
    exit();
}

// Bloco de Validação (Seu bloco original já era muito bom, mantido com pequenas melhorias)
if (!isset($_POST["nomeTabela"]) || !isset($_POST['tabelasPermitidas']) || trim($_POST["nomeTabela"]) === '' || trim($_POST['tabelasPermitidas']) === '') {
    $output['message'] = 'Parâmetro "nome_tabela" é obrigatório e não pode ser vazio.';
    http_response_code(400); // 400 Bad Request
    echo json_encode($output);
    exit();
}

$nomeTabela = trim($_POST["nomeTabela"]);
$tabelasPermitidasString = trim($_POST['tabelasPermitidas']);
$arrayTabelasPermitidas = explode(',', $tabelasPermitidasString);

// Lista de tabelas permitidas. ESSENCIAL PARA SEGURANÇA.
if (!in_array($nomeTabela, $arrayTabelasPermitidas)) {
    $output['message'] = "Acesso negado. A tabela '$nomeTabela' não tem permissão para ser consultada.";
    http_response_code(403); // 403 Forbidden
    echo json_encode($output);
    exit();
}


// Cria uma instância da classe DataSource
$database = new DataSource();

try {
    // Query SQL para selecionar os participantes isentos
    $sql = "SELECT * FROM `$nomeTabela` 
            WHERE status_insc is null ORDER BY `datacad` DESC";

    // Executa a query e obtém o statement
    // Assumindo que selectFetchAll retorna um objeto PDOStatement ou similar
    $stmt = $database->selectFetchAll($sql);

    // Busca todos os resultados como um array associativo
    $participantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Conta o número de participantes encontrados
    $numParticipantes = count($participantes);

    // Verifica se foram encontrados participantes
    if ($numParticipantes > 0) {
        // Inicia a construção da tabela HTML
        $htmlOutput = "<div class='table-responsive'>

            <table class='table table-bordered table-striped' style='margin-top:20px;'>
            <thead>
                <tr>
                    <td colspan='6' align='center' style='color: #fff; text-transform: uppercase;'><b>Participantes inscritos, sem pagamento confirmado<b> </td>
                </tr>
                <tr style='background: linear-gradient(180deg, #FF8A32 0%, #FFB4B4 100%); color: #000;'>
                    <th class='text-center' style='width: 50px;'>Nº</th>
                    <th class='text-left' style='width: 250px;'>Nome</th>
                    <th class='text-left' style='width: 100px;'>Categoria</th>
                    <th class='text-left' style='width: 100px;'>Telefone</th>
                    <th class='text-center' style='width: 80px;'>Data</th>
                    <th class='text-center' style='width: 80px;'>Ação</th>
                </tr>
            </thead>
            <tbody";

        $numeroSequencial = 0;
        foreach ($participantes as $row) {
            $numeroSequencial++;

            // Prepara os dados para o botão de ação, escapando caracteres especiais
            $nomeInscEscapado = htmlspecialchars($row['nome_insc'], ENT_QUOTES, 'UTF-8');
            $idInscEscapado = htmlspecialchars($row['id_insc'], ENT_QUOTES, 'UTF-8');

            // Lógica do botão de ação melhorada
            $acao = "";

            // Novos botões adicionados
            $botao_conf = '<button type="button" onclick="get_param(this);" class="button button1" data-v="Confirmado" data-id="' . $idInscEscapado . '" data-tb="' . $nomeTabela . '"><i class="fas fa-check"></i></button>';
            $botao_isent = '<button type="button" onclick="get_param(this);" class="button button2" data-v="Isento" data-id="' . $idInscEscapado . '" data-tb="' . $nomeTabela . '"><i class="fas fa-pen"></i></button>'; // fas fa-pen é mais comum que fa-solid fa-pen
            $botao_canc = '<button type="button" onclick="get_param(this);" class="button button3" data-v="Cancelado"  data-id="' . $idInscEscapado . '" data-tb="' . $nomeTabela . '"><i class="fas fa-times"></i></button>';
            $botao_del = '<button type="button" onclick="get_param(this);" class="button button4" data-v="Excluir" data-id="' . $idInscEscapado . '" data-tb="' . $nomeTabela . '"><i class="fas fa-trash"></i></button>';

            if (isset($_SESSION['acesso']) && $_SESSION['acesso'] >= 4) {
                $acao .= " " . $botao_conf . " " . $botao_isent . " " . $botao_canc . " " . $botao_del;
            } else if (isset($_SESSION['acesso']) && $_SESSION['acesso'] === 3) {
                $acao .= " " . $botao_conf . " " . $botao_isent . " " . $botao_canc;
            } else {
                $acao = '';
            }


            // Formata a data de cadastro
            $dataCadastroFormatada = date_format(date_create($row['datacad']), 'd/m/Y');

            $htmlOutput .=  "<tr>
                    <td class='text-center'>{$numeroSequencial}</td>
                    <td class='text-left'>" . htmlspecialchars($row['nome_insc'], ENT_QUOTES, 'UTF-8') . "</td>
                    <td class='text-left'>" . htmlspecialchars($row['categoria_insc'], ENT_QUOTES, 'UTF-8') . "</td>
                    <td class='text-left'>" . htmlspecialchars($row['telefone_insc'], ENT_QUOTES, 'UTF-8') . "</td>
                    <td class='text-center'>{$dataCadastroFormatada}</td>
                    <td class='th-acao'>{$acao}</td>
                </tr>";
        }

        $htmlOutput .= "</tbody>
            </table>
        </div>";
    } else {
        // Mensagem exibida se nenhum participante for encontrado
        $htmlOutput = "<div class='alert alert-info text-center' role='alert' style='margin-top:20px; font-size: 22px; font-weight: 600;'>
                    Ops! Nenhum participante encontrado!.
                </div>";
    }
} catch (PDOException $e) {
    // Em caso de erro na consulta ao banco de dados (específico do PDO)
    // Logar o erro para análise interna (não exibir detalhes ao usuário em produção)
    error_log("Erro no banco de dados: " . $e->getMessage());
    $htmlOutput = "<div class='alert alert-danger text-center' role='alert' style='margin-top:20px;'>
                Erro ao consultar os dados. Por favor, tente novamente mais tarde.
            </div>";
} catch (Exception $e) {
    // Em caso de outros erros genéricos
    error_log("Erro geral: " . $e->getMessage());
    $htmlOutput = "<div class='alert alert-danger text-center' role='alert' style='margin-top:20px;'>
                Ocorreu um erro inesperado. Por favor, tente novamente mais tarde.
            </div>";
} finally {
    // Fecha a conexão com o banco de dados, se estiver aberta
    if ($database) {
        $database->closeConection(); // Supondo que este método exista na sua classe DataSource
    }
}

// Exibe o HTML gerado (tabela ou mensagem)
echo $htmlOutput;
