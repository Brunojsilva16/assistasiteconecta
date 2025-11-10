<?php
// include './sconfig/config_email.php';
include './classes/send_status.php';

?>

<?php
// include('./form_mail.php');

$mail = "assistacentro@gmail.com";

$outputc = "<div class='alert alert-success' role='alert' style='margin-top: 50px;'>

<div id='blocoA-confirma'>

<p><img src='cid:logopng'></p>

    <h2 id='statusApedido'><b>Seu inscrição foi realizado com sucesso!</b></h2>
</div>";



$yourmail = new SendMailone;
$yourmail->send($mail, './assets/img/logomail.png', 'Imersão Psicologia e Empreendedorismo', $outputc);
?>