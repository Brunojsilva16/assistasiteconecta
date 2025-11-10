<?php

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

$nome = $_POST['nome'];

// data to embed in the QR code image
// $data = 'https://clinicaassista.com.br/conecta/';
$data = ('https://www.exemplo.com/perfil?id=123');

// configuration options for QR code generation
// eccLevel - Error correction level (L, M, Q, H)
// scale - QR code pixe size
// imageBase64 - output as image resrouce or not
$options = new QROptions([
    'version' => 4,
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
<!DOCTYPE html>
<html>
<head>
    <title>Crachá</title>
    <style>
        /* Estilos CSS para o crachá */
        body {
            font-family: sans-serif;
            text-align: center;
        }
        .cracha {
                background: linear-gradient(#ff9826, #af2846);
                border-radius: 15px;
                padding: 20px;
                width: 240px;
                margin: 0 auto;
        }
        
        .qrcode {
            width: 200px;
        }

        .log {
            background-image: url(./assets/img/conecta.png);
            height: 80px;
            background-repeat: no-repeat;
            background-size: contain;
            background-position: 50% 100%;
        }

    </style>
</head>
<body>
    <div class="cracha">
        <h2>' . $nome . '</h2>
        <p>Credenciamento</p>
        <img class="qrcode" src=' . $qrCodeImage . '>
        <div class="log"></div>
    </div>
</body>
</html>
';

// Exibe o crachá
echo $html;