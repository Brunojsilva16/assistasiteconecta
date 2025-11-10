<?php
include '../classes/send_workshop.php';

$mail = $_POST['email'];

$outputc = "<div class='alert alert-success' role='alert' style='margin-top: 50px;'>

                <p><img src='cid:workshopconf'></p>

            <h2 id='statusApedido'><b>Sua INSCRIÇÃO foi realizada com sucesso!</b></h2> <a href='https://chat.whatsapp.com/EdIilBQgm05AuWmfJMgRvG?mode=ems_wa_c'> Entre aqui no grupo Workshop TUS</a>";

$yourmail = new SendMailtwo;
$yourmail->send($mail, '../assets/tus/workshopconf.png', 'Workshop Manejo Clínico dos Transtornos por Uso de Substâncias', $outputc);
?>