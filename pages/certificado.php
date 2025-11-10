<?php

// require_once 'dompdf/autoload.inc.php';

// require __DIR__.'/vendor/autoload.php';

// require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'dompdf' . DIRECTORY_SEPARATOR . 'autoload.inc.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
// if (!isset($_POST)) {
//     header("location: home");
//     exit();
// }

// $nome = $_POST['nomeuser'];
$nome = 'Bruno Silva';

?>

<?php

//calcular o inicio visualização

$temp = explode(" ", $nome);
$nomeNovo = $temp[0];
$horas = 8;

$page = "<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <title></title>

    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>

</head>

<style type='text/css'>
    body {
        margin: 0;
        padding: 0;
        background-color: #FAFAFA;
        font: 12pt 'Tahoma';
    }

    p {
        text-indent: 60px;
    }

    span {
        color: #007bff;
    }

    .page {
        padding: 0cm;
        margin: 0;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .subpage {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        /* left: 0; */
        /* padding: 0cm; */
        /*right: 10cm;*/
        /*border: 5px red solid;*/
        height: 21cm;
        /*outline: 2cm #FFEAEA solid;*/
    }

    @page {
        size: A4 landscape;
        margin: 0;
    }

    @media print {
        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
            page-break-before: always;
        }
    }

    .container {
        position: relative;
    }

    .centerr {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        position: absolute;
        /* top: 42%; */
        width: 70%;
        text-align: justify;
        font-size: 32px;
        padding: 0;
        /* left: 6%; */
        /* right: -50px; */
        hyphens: auto;
        -webkit-hyphens: auto;
        /* word-spacing: -0.05em; */
    }

    .rodape {
        position: absolute;
        top: 95%;
        width: 85%;
        font-size: 14px;
        padding: 0;
        left: 8%;
    }
</style>

<body>

    <div class='page'>
        <div>
            <img class='subpage' src='./assets/img/certificado.jpg'>
        </div>
        <div class='centerr'>
            <p>Certificamos que <strong>" . $nome . "</strong>, participou da <strong>Imersão Regulação Emocional em Psicoterapia</strong> com <strong>Wilson Vieira Melo</strong>. O evento foi realizado no dia 24 de maio de 2025, no Hotel Luzeiros, em Recife - PE, com carga horária de <strong>" . $horas . " horas</strong>.</p>
        </div>
    </div>

</body>

</html>";


use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);
$options->setChroot(realpath(__DIR__));
// $options->setIsRemoteEnabled(true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($page);

// $contxt = stream_context_create([
//     'http' => [
//         'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
//         'method'  => 'GET',
//         'user_agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)',
//     ],
//     'ssl' => [ 
//         'verify_peer' => FALSE, 
//         'verify_peer_name' => FALSE,
//         'allow_self_signed'=> TRUE,
//     ] 
// ]);


$dompdf->setHttpContext($contxt);

$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
// $dompdf->setPaper('A4', 'portrait');


$dompdf->stream(
    "{$nomeNovo}.pdf",
    array(
        "Attachment" => false //Para realizar o download somente alterar para true
    )
);
