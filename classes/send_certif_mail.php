<?php
// Dentro da classe SendCertif, modifique a função send()


use Dompdf\Dompdf;
use Dompdf\Options;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SendCertif
{

    public function send($nome, $evento, $palestrante, $data, $cargaH, $local, $email, $assunto, $anexoCorpo)
    {
        $outputmsg = array('error' => false);

        // --- INÍCIO DA CORREÇÃO BASE64 ---
        // Caminho para a imagem de fundo do certificado
        $pathToImage = realpath(__DIR__ . '/../assets/tus/certificado.png');

        if ($pathToImage && file_exists($pathToImage)) {
            $type = pathinfo($pathToImage, PATHINFO_EXTENSION);
            $imgData = file_get_contents($pathToImage);
            $imageBase64 = 'data:image/' . $type . ';base64,' . base64_encode($imgData);
        } else {
            $outputmsg['error'] = true;
            $outputmsg['message'] = "Erro: Imagem de fundo do certificado não encontrada.";
            return $outputmsg;
        }
        // --- FIM DA CORREÇÃO BASE64 ---

        $page = "<!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
            <title>Certificado</title>
            <style type='text/css'>
                @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap'); 
                body {
                    margin: 0; 
                    padding: 0; 
                    background-color: #FAFAFA; 
                    font-family: 'Poppins', sans-serif!important;
                    font-size: 12px;
                }
                @page { size: A4 landscape; margin: 0; }
                .page { position: relative; width: 100%; height: 100%; }
                #subpage { background-image: url(" . $imageBase64 . "); background-size: contain; background-position: center; background-repeat: no-repeat; position: absolute; top: 0; left: 0; height: 100%; width: 100%; }
                .centerr { position: absolute; top: 52%; left: 50%; transform: translate(-50%, -50%); width: 78%; text-align: justify; font-size: 22px; padding: 0; hyphens: auto; -webkit-hyphens: auto; }
            </style>
        </head>
        <body>
            <div class='page'>
                <div id='subpage'></div>
                <div class='centerr'>
                    <p>Certificamos que <strong>" . trim(htmlspecialchars($nome)) . "</strong>, participou do <strong>" . htmlspecialchars($evento) . "</strong>, 
                    com <strong>" . htmlspecialchars($palestrante) . "</strong>. O evento foi realizado " . htmlspecialchars($data) . ", 
                    " . htmlspecialchars($local) . " com carga horária de <strong>" . htmlspecialchars($cargaH) . " horas</strong>.</p>
                </div>
            </div>
        </body>
        </html>";

        $options = new Options();
        $options->set('isRemoteEnabled', true); // Necessário para a imagem base64 e qualquer outro recurso externo

        // O chroot não é mais estritamente necessário para a imagem de fundo, mas pode ser mantido por segurança
        // $options->setChroot(realpath(__DIR__ . '/../')); 

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($page);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $output = $dompdf->output();

        // O restante do código do PHPMailer continua igual...
        $mailSender = new PHPMailer(true);
        // ...
        // try { ... } catch { ... }
        // ...
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
            // $mailSender->AddEmbeddedImage($localAnexo, "techeckin", "techeckin.png");
            $mailSender->addStringAttachment($output, 'certificado.pdf');

            if (!$mailSender->Send()) {
                $outputmsg['error'] = true;
                $outputmsg['message'] = "Erro ao enviar o email: " . $mailSender->ErrorInfo;
            } else {
                $outputmsg['success'] = "Email enviado com sucesso para " . $nome . "!";
            }
        } catch (Exception $e) {
            $outputmsg['error'] = true;
            $outputmsg['message'] = "Ocorreu um erro no envio do email: " . $e->getMessage();
        }

        return $outputmsg;
    }
}
