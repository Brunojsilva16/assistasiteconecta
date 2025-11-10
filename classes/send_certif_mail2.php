<?php

use Dompdf\Dompdf;
use Dompdf\Options;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SendCertif
{
    public function send($nome, $evento, $palestrante, $data, $cargaH, $local, $email, $localAnexo, $assunto, $anexoCorpo)
    {
        $outputmsg = array('error' => false);
        $temp = explode(" ", $nome);
        $nomeNovo = $temp[0];

        $page = "<!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <title>Certificado</title>
            <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
            <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>
            <style type='text/css'>
                body { margin: 0; padding: 0; background-color: #FAFAFA; font: 12pt 'Tahoma'; }
                p { text-indent: 60px; }
                span { color: #007bff; }
                .page { padding: 0cm; margin: 0; background: white; box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); }
                #subpage { background-image: url(../assets/img/certificado.png); background-size: contain; background-repeat: no-repeat; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); height: 100%; width: 100%; }
                @page { size: A4 landscape; margin: 0; }
                @media print { .page { margin: 0; border: initial; border-radius: initial; width: initial; min-height: initial; box-shadow: initial; background: initial; page-break-after: always; page-break-before: always; } }
                .container { position: relative; }
                .centerr { position: absolute; top: 52%; left: 50%; transform: translate(-50%, -50%); position: absolute; width: 78%; text-align: justify; font-size: 32px; padding: 0; hyphens: auto; -webkit-hyphens: auto; }
                .rodape { position: absolute; top: 95%; width: 85%; font-size: 14px; padding: 0; left: 8%; }
            </style>
        </head>
        <body>
            <div class='page'>
                <div id='subpage'></div>
                <div class='centerr'>
                    <p>Certificamos que <strong>" . $nome . "</strong>, participou da <strong>" . $evento . "</strong> com <strong>" . $palestrante . "</strong>. O evento foi realizado " . $data . ", no " . $local . ", com carga horária de <strong>" . $cargaH . " horas</strong>.</p>
                </div>
            </div>
        </body>
        </html>";

        $caminhoBase = __DIR__ . '/../assets/img';
        $caminhoBaseReal = realpath($caminhoBase);

        if ($caminhoBaseReal === false) {
            $outputmsg['error'] = true;
            $outputmsg['message'] = "Erro: O diretório de imagens não foi encontrado.";
            return $outputmsg;
        }

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->setChroot($caminhoBaseReal);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($page);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $output = $dompdf->output();

        $mailSender = new PHPMailer(true);

        try {
            $mailSender->SMTPDebug = 0;
            $mailSender->CharSet = MAIL_CHARSET;
            $mailSender->IsSMTP();
            $mailSender->Host = MAIL_HOST;
            $mailSender->SMTPAuth = true;
            $mailSender->isHTML(true);
            $mailSender->Username = MAIL_USERNAME_PRINC;
            $mailSender->Password = MAIL_PASSWORD;
            $mailSender->SMTPSecure = MAIL_ENCRYPTION;
            $mailSender->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true));
            $mailSender->Port = 465;

            $mailSender->setFrom(MAIL_USERNAME_PRINC, 'Assista Conecta');
            $mailSender->Subject = $assunto;
            $mailSender->Body = $anexoCorpo;
            $mailSender->addAddress($email);
            $mailSender->AddEmbeddedImage($localAnexo, "logocheckin", "logocheckin.png");
            $mailSender->addStringAttachment($output, 'certificado.pdf');

            if (!$mailSender->Send()) {
                $outputmsg['error'] = true;
                $outputmsg['message'] = "Erro ao enviar o email: " . $mailSender->ErrorInfo;
            } else {
                $outputmsg['success'] = "Email enviado com sucesso para " . $email . "!";
            }

        } catch (Exception $e) {
            $outputmsg['error'] = true;
            $outputmsg['message'] = "Ocorreu um erro no envio do email: " . $e->getMessage();
        }

        return $outputmsg;
    }
}

class SendCertifone extends SendCertif
{
    public function __construct()
    {
        $this->includes();
    }

    private function includes()
    {
        require './vendor/autoload.php';
        require './sconfig/config_email.php';
    }
}

class SendCertiftwo extends SendCertif
{
    public function __construct()
    {
        $this->includes();
    }

    private function includes()
    {
        require '../vendor/autoload.php';
        require '../sconfig/config_email.php';
    }
}