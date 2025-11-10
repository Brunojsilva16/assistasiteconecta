<?php
include '../classes/send_papo.php';

$mail = $_POST['email'];

$outputc = "<div class='alert alert-success' role='alert' style='margin-top: 50px;'>

                <p><img src='cid:papofamilia'></p>

            <h2 id='statusApedido'><b>Sua PRÉ-INSCRIÇÃO foi realizada com sucesso!</b></h2> <a href='https://chat.whatsapp.com/I4qC9bMPDlb0n3ZTJRqVqj'> Entre aqui no grupo Vip</a>";

$yourmail = new SendMailtwo;
$yourmail->send($mail, '../assets/papo/papofamilia.jpg', 'Papo Família', $outputc);
?>