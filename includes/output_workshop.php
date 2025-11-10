<?php
include '../classes/send_workshop.php';

$mail = $_POST['email'];

$outputc = "<div class='alert alert-success' role='alert' style='margin-top: 50px;'>

                <p><img src='cid:workshoppr'></p>

            <h2 id='statusApedido'><b>Sua PRÉ-INSCRIÇÃO foi realizada com sucesso!</b></h2>";

$yourmail = new SendMailtwo;
$yourmail->send($mail, '../assets/tus/workshoppr.png', 'Workshop Manejo Clínico dos Transtornos por Uso de Substâncias', $outputc);
?>