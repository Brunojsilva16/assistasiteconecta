<?php

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

$nome = $_POST['nome'];
$token_unico = $_POST['id'];
// $id = 1222;

// data to embed in the QR code image
$data = "https://assistaconecta.com.br/checkin?idtoken=" . urlencode($token_unico);

// configuration options for QR code generation
// eccLevel - Error correction level (L, M, Q, H)
// scale - QR code pixe size
// imageBase64 - output as image resrouce or not
$options = new QROptions([
    'version' => 5,
    'scale' => 4,
    'imageBase64' => true,
    'imageTransparent' => false,
    'foregroundColor' => '#000000',
    'backgroundColor' => '#ffffff'
]);

// Instantiating the code QR code class
$qrCode = new QRCode($options);

// generating the QR code image happens here
$qrCodeImage = $qrCode->render($data);

$html = '
    <div id="crachar_download" class="cracha" 
        style="background: linear-gradient(135deg, #ff9826, #af2846);
                    padding: 20px;
                    // border-radius: 16px!important;
                    width: 100%;
                    height: auto;
                    margin: 0;
                    color: #fff;">
        <h2>' . $nome . '</h2>
        <p style="margin-bottom: 10px">Credenciamento</p>
        <img class="qrcode" src=' . $qrCodeImage . ' style="width: 300px;">
        <div class="log" style="    background-image: url(./assets/img/conecta.png);
            margin-top: 20px;
            height: 80px;
            background-repeat: no-repeat;
            background-size: contain;
            background-position: 50% 100%;">
    </div>
';
// Exibe o crachá
echo $html;
