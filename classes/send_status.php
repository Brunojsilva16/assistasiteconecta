<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SendMail
{
    public function send($email, $img, $subject, $body)
    // public function send($email, $subject, $body)
    {
        // echo "acesso a classe";
        $mail = new PHPMailer(true);

        try {

            $mail->SMTPDebug = 0;
            $mail->CharSet = MAIL_CHARSET;
            $mail->IsSMTP();
            $mail->Host = MAIL_HOST;
            $mail->SMTPAuth = true;
            $mail->isHTML(true);
            $mail->Username = MAIL_USERNAME_PRINC;
            $mail->Password = MAIL_PASSWORD;
            $mail->SMTPSecure = MAIL_ENCRYPTION;

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->Port = 465; // 465 or 587

            $mail->setFrom(MAIL_USERNAME_PRINC, 'Assista Conecta');
            $mail->Subject = $subject;
            $mail->Body    = $body;

            //Recipients
            $mail->addAddress($email);
            $mail->addAddress("assistaconecta@gmail.com");
            //Content
            $mail->AddEmbeddedImage($img, "regulacaopre", "regulacaopre.png");

            if (!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                // echo "Email enviado com sucesso!";
            }
            // ****************
        } catch (Exception $e) {
            echo $e->errorMessage();
            // exit;
        }
    }
}

class SendMailone extends SendMail
{
    public function __construct()
    {
        $this->includes();
    }

    private function includes()
    {
        require './vendor/autoload.php';
        require './sconfig/config_email.php';
        // require './includes/s_config.php';
    }
}

class SendMailtwo extends SendMail
{
    public function __construct()
    {
        $this->includes();
    }

    private function includes()
    {
        require '../vendor/autoload.php';
        require '../sconfig/config_email.php';
        // require './includes/s_config.php';
    }
}
