<?php

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

// data to embed in the QR code image
$data = 'https://clinicaassista.com.br/conecta/';

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

echo "<img src='$qrCodeImage' width='380px'>";



