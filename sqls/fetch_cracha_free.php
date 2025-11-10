<?php

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

$finalNome = $_POST['nome'];
$link = $_POST['link'];
$cor = $_POST['checkcor'];
// data to embed in the QR code image

$data = ("$link");

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
    <div id="crachar_download" class="cracha" 
        style="background: linear-gradient(135deg, #ff9826, #af2846);
                    padding: 20px;
                    // border-radius: 16px!important;
                    width: 100%;
                    height: auto;
                    margin: 0;
                    color: #fff;">
        <h2>' . $finalNome . '</h2>
        <img class="qrcode" src=' . $qrCodeImage . ' style="width: 300px;">
        ';

$html_nocolor = '
    <div id="crachar_download" class="cracha" 
        style="padding: 20px;
                    width: 100%;
                    height: auto;
                    margin: 0;
                    color: #fff;">
        <h2 style="color: #000;">' . $finalNome . '</h2>
        <img class="qrcode" src=' . $qrCodeImage . ' style="width: 300px;">
        ';

if ($cor != 'true') {
    echo $html;
}else {
    echo $html_nocolor;
}

// Exibe o crachá
