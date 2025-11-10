<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';
// Define o tipo de conteúdo da resposta como JSON
header('Content-Type: application/json');

// Inclui sua classe e configurações. 
// 2. INCLUA SEU ARQUIVO DE CONFIGURAÇÃO AQUI
//    Substitua 'config.php' pelo nome real do seu arquivo.
require '../sconfig/config_email.php';

// Use a classe SendCertiftwo, que parece ser a correta para um arquivo em um subdiretório.
// Ajuste o caminho se necessário.
require_once '../classes/send_certif_mail.php';

// Valida se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => true, 'message' => 'Método não permitido.']);
    exit;
}

/**
 * Padroniza um nome completo para o formato "Primeiras Letras Maiúsculas".
 * Preposições e artigos (de, da, do, e, etc.) são mantidos em minúsculas,
 * exceto quando são a primeira palavra do nome.
 * A função utiliza mb_string para lidar corretamente com acentos (UTF-8).
 *
 * @param string $nome O nome completo a ser formatado.
 * @return string O nome formatado.
 */
function padronizarNomeCompleto($nome) {
    // Lista de palavras que devem permanecer em minúsculas
    $excecoes = ['e', 'de', 'da', 'do', 'das', 'dos'];

    // 1. Converte toda a string para minúsculas, lidando com acentos
    $nomeEmMinusculo = mb_strtolower($nome, 'UTF-8');

    // 2. Separa a string em um array de palavras
    $palavras = explode(' ', $nomeEmMinusculo);

    $nomeFinal = [];

    // 3. Percorre cada palavra
    foreach ($palavras as $key => $palavra) {
        // 4. Capitaliza a palavra se:
        //    - for a primeira palavra (key === 0)
        //    - OU não estiver na lista de exceções
        if ($key === 0 || !in_array($palavra, $excecoes)) {
            // Pega a primeira letra, converte para maiúscula e concatena com o resto da palavra
            $primeiraLetra = mb_strtoupper(mb_substr($palavra, 0, 1, 'UTF-8'), 'UTF-8');
            $restoDaPalavra = mb_substr($palavra, 1, null, 'UTF-8');
            $nomeFinal[] = $primeiraLetra . $restoDaPalavra;
        } else {
            // 5. Se for uma exceção (e não a primeira palavra), mantém em minúsculas
            $nomeFinal[] = $palavra;
        }
    }

    // 6. Junta as palavras novamente em uma única string
    return implode(' ', $nomeFinal);
}

// Dados do corpo do e-mail e anexo (você pode customizar isso)
$assuntoEmail = "Seu certificado do evento " . $_POST['evento'] . " 2025";
// $caminhoLogo = realpath('../assets/te/techeckin.png'); // Caminho para a imagem do corpo do e-mail
$corpoEmail = "
    <p>Olá, " . $_POST['nome'] . ".</p>
    <p>É com grande satisfação que enviamos seu certificado de participação no evento <strong>" . $_POST['evento'] . " 2025</strong>.</p>
    <p>Agradecemos sua presença!</p>
    <p>Atenciosamente,</p>
    <p>Equipe Assista Conecta</p>
    <br>
";

// Pega o nome vindo do POST
$nomeOriginal = $_POST['nome'];

// Aplica a padronização
$nomeFormatado = padronizarNomeCompleto($nomeOriginal);

// Cria uma instância da sua classe
// Escolha SendCertifone ou SendCertiftwo dependendo da estrutura do seu projeto
$sender = new SendCertif();

// Chama a função de envio com os dados recebidos do JavaScript
$response = $sender->send(
    $nomeFormatado,
    $_POST['evento'],
    $_POST['palestrante'],
    $_POST['data'],
    $_POST['cargaH'],
    $_POST['local'],
    $_POST['email'],
    // $caminhoLogo,      // $localAnexo para a imagem no corpo do email
    $assuntoEmail,     // $assunto
    $corpoEmail        // $anexoCorpo
);

// Retorna a resposta (sucesso ou erro) da classe em formato JSON
echo json_encode($response);
