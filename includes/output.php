<?php
include '../classes/send_status.php';

$mail = $_POST['email'];

$outputc = "<div class='alert alert-success' role='alert' style='margin-top: 50px;'>

                <p><img src='cid:regulacaopre'></p>

            <h2 id='statusApedido'><b>Sua PRÉ-INSCRIÇÃO foi realizada com sucesso!</b></h2> <a href='https://chat.whatsapp.com/GnmFlmdyR8W6qFY2IrEFE0'> Entre aqui no grupo Vip</a>";

$yourmail = new SendMailtwo;
$yourmail->send($mail, '../assets/img/regulacaopre.png', 'Imersão Regulação Emocional em Psicoterapia', $outputc);

// $caminho = $_POST['caminho'];
// $assunto = $_POST['corpo'];
// $yourmail->send($mail, $caminho, $assunto, $outputc);
?>

