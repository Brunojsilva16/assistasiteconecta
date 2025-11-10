<?php
include '../classes/send_check-in.php';

$mail = $_POST['email'];

$outputc = "<p><img src='cid:logocheckin' alt='Imagem Anexada'></p>";

$yourmail = new SendChecktwo;
$yourmail->send($mail, '../assets/img/logocheckin.png', 'Agora você é um(a) PSI CONECTADO(A)!', $outputc);
?>