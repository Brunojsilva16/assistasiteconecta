<?php

// Inclui o autoloader do Composer
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// Importa as classes necessárias da biblioteca endroid/qr-code
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

// --- DADOS DE ENTRADA ---
$nome = $_POST['nome'] ?? 'Nome Sobrenome'; // Usa valores padrão para teste se não houver POST
$id = $_POST['id'] ?? '12345';             // Usa valores padrão para teste

// Prepara o nome para exibição no crachá
$palavras = explode(" ", trim($nome));
$primeiroNome = $palavras[0];
$ultimoNome = end($palavras);
$finalNome = count($palavras) > 1 ? $primeiroNome . ' ' . $ultimoNome : $primeiroNome;

// --- CONFIGURAÇÃO DO QR CODE ---

// Data a ser embutida na imagem do QR code
$data = "https://meusite.com.br/check-in?idtoken=$id";

// Caminho para o arquivo da sua logo
$logoFile = __DIR__ . '/../assets/te/conecta_logo.png'; // IMPORTANTE: Verifique se este caminho está correto

if (!file_exists($logoFile)) {
    die('Arquivo de logo não encontrado em: ' . $logoFile);
}

// --- GERAÇÃO DO QR CODE COM LOGO USANDO O BUILDER ---

// O Builder torna a criação do QR code muito mais legível e fluida
$result = Builder::create()
    ->writer(new PngWriter())
    ->writerOptions([])
    ->data($data)
    ->encoding(new Encoding('UTF-8'))
    // Nível de correção de erro ALTO é essencial para que o QR code funcione com uma logo no meio
    ->errorCorrectionLevel(ErrorCorrectionLevel::High)
    ->size(350) // Tamanho final da imagem em pixels
    ->margin(10) // Margem branca ao redor do QR code
    ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
    // --- Configurações da Logo ---
    ->logoPath($logoFile) // Caminho para o arquivo da sua logo
    ->logoResizeToWidth(60) // Redimensiona a logo para uma largura de 60 pixels
    ->logoPunchoutBackground(true) // Cria um espaço branco atrás da logo para melhor leitura
    ->build();

// Obtém a imagem final diretamente como uma string Data URI (base64)
$qrCodeImageBase64 = $result->getDataUri();


// --- GERAÇÃO DO HTML FINAL ---
$html = '
    <div id="crachar_download" class="cracha" 
        style="background: linear-gradient(135deg, #ff9826, #af2846);
                    padding: 20px;
                    width: 100%;
                    height: auto;
                    margin: 0;
                    color: #fff;
                    text-align: center;
                    border-radius: 16px;">
        <h2>' . htmlspecialchars($finalNome) . '</h2>
        <p>Credenciamento</p>
        <div style="background: #fff; padding: 10px; border-radius: 12px; display: inline-block; margin-top: 15px;">
            <img class="qrcode" src="' . $qrCodeImageBase64 . '" alt="QR Code de Credenciamento" style="width: 300px; max-width: 100%; height: auto; display: block;">
        </div>
        <div class="log" style="background-image: url(./assets/img/conecta.png);
            margin-top: 20px;
            height: 80px;
            background-repeat: no-repeat;
            background-size: contain;
            background-position: center;">
    </div>
</div>';

// Exibe o crachá
echo $html;

?>
