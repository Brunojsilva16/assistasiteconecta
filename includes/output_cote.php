<?php
include '../classes/send_cote.php';

$mail = $_POST['email'];
$cate = $_POST['categoria'];

switch ($cate) {
    
    case 'onze':
        $outputc = "<div class='alert alert-success' role='alert' style='margin-top: 50px;'>

                <p><img src='cid:marketing-11'></p>

            <h2 id='statusApedido'><b>Sua PRÉ-INSCRIÇÃO foi realizada com sucesso!</b></h2>";

        $yourmail = new SendMailtwo;
        $yourmail->send($mail, '../assets/colonia/marketing-11.png', 'Colonia Terapeutica', $outputc, 'marketing-11');
        break;

    case 'dezoito':
        $outputc = "<div class='alert alert-success' role='alert' style='margin-top: 50px;'>

                <p><img src='cid:marketing-18'></p>

            <h2 id='statusApedido'><b>Sua PRÉ-INSCRIÇÃO foi realizada com sucesso!</b></h2>";

        $yourmail = new SendMailtwo;
        $yourmail->send($mail, '../assets/colonia/marketing-18.png', 'Colonia Terapeutica', $outputc, 'marketing-18');
        break;

    case 'dois':
        $outputc = "<div class='alert alert-success' role='alert' style='margin-top: 50px;'>

                <p><img src='cid:marketing-02'></p>

            <h2 id='statusApedido'><b>Sua PRÉ-INSCRIÇÃO foi realizada com sucesso!</b></h2>";

        $yourmail = new SendMailtwo;
        $yourmail->send($mail, '../assets/colonia/marketing-02.png', 'Colonia Terapeutica', $outputc, 'marketing-02');
        break;
}
