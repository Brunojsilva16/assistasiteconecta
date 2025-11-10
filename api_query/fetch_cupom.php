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
$htmlOutputii = '';

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
	$sql = "SELECT i.cupom_insc, cd.nome_cod, COUNT(*) AS insc_cupom
			FROM 
				`$nomeTabela` as i
			LEFT JOIN 
				codigo as cd on i.cupom_insc = cd.codigo_cod
			WHERE 
				i.status_insc = 'Confirmado' OR i.status_insc = 'Isento' AND i.cupom_insc = 'ASSISTA2003'

			GROUP BY 
				i.cupom_insc
			ORDER BY insc_cupom ASC";

	// Executa a query e obtém o statement
	// Assumindo que selectFetchAll retorna um objeto PDOStatement ou similar
	$stmt = $database->selectFetchAll($sql);

	// Busca todos os resultados como um array associativo
	$participantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

	// Conta o número de participantes encontrados
	$numParticipantes = count($participantes);

	// Verifica se foram encontrados participantes
	if ($numParticipantes > 0) {


		$htmlOutput = "<div class='table-responsive'>
			<table class='table table-bordered table-striped' style='margin-top:20px;'>
			<thead>
				<tr colspan='4' align='center' style='color: #fff; text-transform: uppercase;'><b>Tabela de cupons usados nas vendas<b> </tr>
					</tr>
				<tr style='background: linear-gradient(180deg, #FF8A32 0%, #FFB4B4 100%); color: #000'>
						<th class='text-center'>Nº</th>
						<th class='text-center'>Profissional</th>
						<th class='text-center'>Código do cupom</th>
						<th class='text-center'>Cupons usados</th>
					</tr>
				</thead>
			<tbody";

		$numeroSequencial = 0;
		foreach ($participantes as $row) {

			if (($row['cupom_insc']) == NULL) continue;

			$numeroSequencial++;

			// Adiciona a linha na tabela
			$htmlOutput .= "<tr>
			<td class='text-center'>{$numeroSequencial}</td>
			<td class='text-left' >{$row['cupom_insc']}</td>
			<td class='text-center'>{$row['nome_cod']}</td>
			<td class='text-center'>" . htmlspecialchars($row['insc_cupom'], ENT_QUOTES, 'UTF-8') . "</td>
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
}

echo $htmlOutput;


try {
	// Query SQL para selecionar os participantes isentos
	$sqlii = "SELECT i.nome_insc, i.cupom_insc, cd.nome_cod
				FROM 
					`$nomeTabela` as i
				LEFT JOIN 
					codigo as cd on i.cupom_insc = cd.codigo_cod
				WHERE 
					i.status_insc = 'Confirmado' OR i.status_insc = 'Isento' AND i.cupom_insc = 'ASSISTA2003'
				ORDER BY i.cupom_insc ASC";


	// Executa a query e obtém o statement
	// Assumindo que selectFetchAll retorna um objeto PDOStatement ou similar
	$stmt = $database->selectFetchAll($sqlii);

	// Busca todos os resultados como um array associativo
	$participantesii = $stmt->fetchAll(PDO::FETCH_ASSOC);

	// Conta o número de participantes encontrados
	$numParticipantesii = count($participantesii);

	// Verifica se foram encontrados participantes
	if ($numParticipantesii > 0) {


		$htmlOutputii = "<div class='table-responsive'>
			<table class='table table-bordered table-striped' style='margin-top:20px;'>
			<thead>
			     <tr>
					<td colspan='4' align='center' style='color: #fff; text-transform: uppercase;'><b>Tabela de cupons usado por participante<b> </td>
				</tr>
					<tr>
						<th class='text-center' style='width: 50px;'>Nº</th>
						<th class='text-left' style='width: 250px;'>Nome</th>
						<th class='text-center' style='width: 60px;'>Código do cupom</th>
						<th class='text-center' style='width:100px;'>Profissional Venda</th>
					</tr>
				</thead>
			<tbody";
		$numeroSequencial = 0;
		foreach ($participantesii as $row) {

			if (($row['cupom_insc']) == NULL) continue;

			$numeroSequencial++;

			$htmlOutputii .= "<tr>
						<td class='text-center'>{$numeroSequencial}</td>
						<td class='text-left'>" . htmlspecialchars($row['nome_insc'], ENT_QUOTES, 'UTF-8') . "</td>
						<td class='text-center'>{$row['cupom_insc']}</td>
						<td class='text-center'>{$row['nome_cod']}</td>
					</tr>";
		}

		$htmlOutputii .= "</tbody>
            </table>
        </div>";
	} else {
		// Mensagem exibida se nenhum participante for encontrado
		$htmlOutputii = "<div class='alert alert-info text-center' role='alert' style='margin-top:20px; font-size: 22px; font-weight: 600;'>
					Ops! Nenhum participante encontrado!.
				</div>";
	}
} catch (PDOException $e) {
	// Em caso de erro na consulta ao banco de dados (específico do PDO)
	// Logar o erro para análise interna (não exibir detalhes ao usuário em produção)
	error_log("Erro no banco de dados: " . $e->getMessage());
	$htmlOutputii = "<div class='alert alert-danger text-center' role='alert' style='margin-top:20px;'>
				Erro ao consultar os dados. Por favor, tente novamente mais tarde.
			</div>";
} catch (Exception $e) {
	// Em caso de outros erros genéricos
	error_log("Erro geral: " . $e->getMessage());
	$htmlOutputii = "<div class='alert alert-danger text-center' role='alert' style='margin-top:20px;'>
				Ocorreu um erro inesperado. Por favor, tente novamente mais tarde.
			</div>";
}

if ($database) {
	$database->closeConection(); // Supondo que este método exista na sua classe DataSource
}
echo $htmlOutputii;
