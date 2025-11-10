<?php
include '../classes/send_cce_te.php';

$mail = $_POST['email'];

$outputc = "<div class='alert alert-success' role='alert' style='margin-top: 50px;'>

                <p><img src='cid:cceteexperience'></p>

            <h2 id='statusApedido'><b>Sua PRÉ-INSCRIÇÃO foi realizada com sucesso!</b></h2> <a href='https://chat.whatsapp.com/JknkpfwnDZZJg9B59wHzis'> Entre aqui no grupo Vip</a>";

$yourmail = new SendMailtwo;
$yourmail->send($mail, '../assets/te/cceteexperience.png', 'TE Experience', $outputc);
?>