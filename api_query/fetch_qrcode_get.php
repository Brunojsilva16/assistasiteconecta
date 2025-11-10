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
$nome = $_POST['nome'] ?? 'Visitante';
$token_unico = $_POST['id'] ?? null;

// Data a ser embutida na imagem do QR code
$data = "https://meusite.com.br/check-in?idtoken=" . urlencode($token_unico);

// --- GERAÇÃO DO QR CODE SEM LOGO USANDO O BUILDER ---

// O Builder torna a criação do QR code muito mais legível e fluida
$result = Builder::create()
    ->writer(new PngWriter())
    ->writerOptions([])
    ->data($data)
    ->encoding(new Encoding('UTF-8'))
    // Para um QR code sem logo, um nível de correção médio é suficiente e eficiente.
    ->errorCorrectionLevel(ErrorCorrectionLevel::Medium)
    ->size(350) // Tamanho final da imagem em pixels
    ->margin(10) // Margem branca ao redor do QR code
    ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
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
        <h2>' . htmlspecialchars($nome) . '</h2>
        <p>Credenciamento</p>
        <div style="background: #fff; padding: 10px; border-radius: 12px; display: inline-block; margin-top: 15px;">
            <img class="qrcode" src="' . $qrCodeImageBase64 . '" alt="QR Code de Credenciamento" style="width: 300px; max-width: 100%; height: auto; display: block;">
        </div>
    </div>
</div>';

// Exibe o crachá
echo $html;

?>
