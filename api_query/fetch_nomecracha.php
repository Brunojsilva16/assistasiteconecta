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
// $allowedTables = ['inscricao', 'papo', 'papo_two', 'papo_three', 'te_inscricao', 'workshop', 'workshop_tus'];
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
			WHERE `status_insc` = 'Confirmado' OR `status_insc` = 'Isento' 
			ORDER BY `nome_insc` ASC";

	// Executa a query e obtém o statement
	// Assumindo que selectFetchAll retorna um objeto PDOStatement ou similar
	$stmt = $database->selectFetchAll($sql);

	// Busca todos os resultados como um array associativo
	$participantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

	// Conta o número de participantes encontrados
	$numParticipantes = count($participantes);

	// Verifica se foram encontrados participantes
	if ($numParticipantes > 0) {
		// ... (cabeçalho da tabela permanece o mesmo) ...
		$htmlOutput = "<div class='table-responsive'>
			<table class='table table-bordered table-striped' style='margin-top:20px;'>
			<thead>
				<tr>
					<td colspan='7' align='center' style='color: #fff; text-transform: uppercase;' ><b>Tabela dos Participantes confirmado<b> </td>
				</tr>
				<tr>
					<th class='text-center' style='width: 50px;'>Nº</th>
					<th class='text-left' style='width: 250px;'>Nome</th>
					<th class='text-left' style='width: 150px;'>NomeCracá</th>
					<th class='text-left' style='width: 150px;'>Telefone</th>
					<th class='text-left' style='width: 100px;'>Categoria</th>
					<th class='text-center' style='width: 150px;'>Email</th>
					<th class='text-center'>Gerar QrCode</th>
				</tr>
				</thead>
			<tbody";


		function getPrimeiroESegundoNome($nomeCompleto)
		{
			// Lista de preposições a ignorar
			$ignorar = ['da', 'de', 'do', 'das', 'dos'];

			// Quebra o nome em palavras
			$partes = explode(' ', trim($nomeCompleto));

			$nomesValidos = [];
			foreach ($partes as $parte) {
				if (!in_array(strtolower($parte), $ignorar)) {
					$nomesValidos[] = $parte;
				}
				if (count($nomesValidos) === 2) {
					break; // Já temos o primeiro e o segundo
				}
			}

			// Junta apenas os dois primeiros nomes válidos
			return implode(' ', $nomesValidos);
		}

		// Uso no seu caso:

		$numeroSequencial = 0;
		foreach ($participantes as $row) {
			$numeroSequencial++;

			$nomecracha = !empty($row['nomecracha_insc'])
				? htmlspecialchars($row['nomecracha_insc'], ENT_QUOTES, 'UTF-8')
				: htmlspecialchars(getPrimeiroESegundoNome($row['nome_insc']), ENT_QUOTES, 'UTF-8');

			$acao = '<button type="button" onclick="getQrcodeParam(this);" class="button button1" data-v="Confirmado" data-nome="' . $nomecracha . '" data-id="' . $row['id_insc'] . '"><i class="fas fa-check"></i></button>';

			// Armazena o telefone em uma variável para facilitar o uso
			$telefone = htmlspecialchars($row['telefone_insc'], ENT_QUOTES, 'UTF-8');
			$email = htmlspecialchars($row['email_insc'], ENT_QUOTES, 'UTF-8');
			$stringMaiuscula = strtoupper($nomecracha);


			$htmlOutput .=  "<tr>
				<td class='text-center'>{$numeroSequencial}</td>
				<td class='text-left'>" . htmlspecialchars($row['nome_insc'], ENT_QUOTES, 'UTF-8') . "</td>
				<td class='text-left'>
				
				<span>" . $stringMaiuscula . "</span><br>

					<button 
						type='button' 
						class='btn btn-secondary btn-sm copiar' 
						onclick=\"copiarTexto('" . $stringMaiuscula . "', this)\"'>
						Copiar
					</button>			 
				</td>
				
				<td class='text-left'>
					<span>" . $telefone . "</span><br>
					<button 
						type='button' 
						class='btn btn-secondary btn-sm copiar' 
						onclick=\"copiarTexto('" . $telefone . "', this)\"'>
						Copiar
					</button>
				</td>
				
				<td class='text-center'>" . htmlspecialchars($row['categoria_insc'], ENT_QUOTES, 'UTF-8') . "</td>
				<td class='text-center'>
					<span>" . $email . "</span><br>
					<button 
						type='button' 
						class='btn btn-secondary btn-sm copiar' 
						onclick=\"copiarTexto('" . $email . "', this)\"'>
						Copiar
					</button>
				</td>
				<td class='text-center' width='160px'> $acao </td>

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
