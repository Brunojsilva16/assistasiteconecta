<?php

// use LoginstatusBase\LoginB;
// use LoginstatusMaster\LoginM;

// require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataLoginB.php';
// require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataLoginM.php';

// if (count($_GET) > 1) {

//     if (session_status() !== PHP_SESSION_ACTIVE) {
//         session_start();
//     }

//     if (!empty($_SESSION['nivel_accesso'])) {

//         if ($_SESSION['nivel_accesso'] > 1) {
//             $login = new LoginM();
//         } else {
//             $login = new LoginB();
//         }

//         if ($login->isLoggedIn()) {
//             $userData = $login->getUserData();

//         } else {
//             header('Location: login');
//             exit();
//         }
//     } else {
//         header('Location: login');
//         exit();
//     }
//     $ch = $_GET['idch'];
// } else {
//     echo 'Método de acesso Negado!';
//     exit;
// }
?>

<!-- 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" href="./assets/img/favicon.png" sizes="32x32">
</head>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.0.1/dist/chart.umd.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.all.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {

        chamadaChck();

        function chamadaChck() {

            var qrid = '<?php echo $ch; ?>';

            $.ajax({
                method: 'POST',
                url: './sqls/fetch_cred.php',
                data: {
                    idch: qrid
                },
                dataType: 'json',

                success: function(response) {
                    // console.log(response);

                    if (response.error) {
                        Swal.fire({
                            icon: "error",
                            title: response.nome,
                            text: response.message,
                            confirmButtonColor: "#871919",
                        });

                    } else {

                        Swal.fire({
                            icon: "success",
                            title: response.nome,
                            text: response.message,
                            // footer: '<a href="#">Why do I have this issue?</a>'
                            confirmButtonColor: "#198754",
                            // timer: 2000,

                            willClose: () => {
                                if (response.envio) {
                                    enviaCheck_in(response.nome, response.email);
                                    // console.log('email disparado!' + ' ' + response.email);
                                }
                                // console.log('email disparado!' + ' ' + response.email + ' ' + response.nome);
                            },
                            timer: 1500,

                        });
                    }
                }
            });
        }
    });

    function enviaCheck_in(nome, email) {

        $.ajax({
            url: './includes/out_cert_env.php', // Substitua pelo caminho correto do seu arquivo PHP
            type: 'POST',
            dataType: 'json', // Espera receber a resposta no formato JSON
            data: {
                // nome: 'Nome Completo',
                nome: nome,
                evento: 'Imersão Regulação Emocional em Psicoterapia',
                palestrante: 'Wilson Vieira Melo',
                data: 'no dia 24 de maio de 2025',
                cargaH: '10',
                local: 'Hotel Luzeiros, em Recife - PE',
                email: email,
                assunto: 'Bem vindo(a), agora você é um(a) PSI CONECTADO(A)!',
                anexoCorpo: "<p><img src='cid:logocheckin' alt='Imagem Anexada'></p>"
            },
            success: function(data) {
                // console.log(data);

                if (data.error) {

                    Swal.fire({
                            icon: "error",
                            title: data.message,
                            // text: response.message,
                            confirmButtonColor: "#871919",
                        });

                    // console.error('Erro:', data.message);
                    // Trate o erro (exiba uma mensagem para o usuário, etc.)
                } else if (data.success) {

                    Swal.fire({
                            icon: "success",
                            // title: data.success,
                            text: data.success,
                            // footer: '<a href="#">Why do I have this issue?</a>'
                            confirmButtonColor: "#198754",
                            // timer: 2000,
                            timer: 3000,
                        });

                    // console.log('Sucesso:', data.success);
                    // Trate o sucesso (exiba uma mensagem para o usuário, redirecione, etc.)
                }
            },
            error: function(xhr, status, error) {
                console.error('Erro na requisição AJAX:', status, error);
                // Trate o erro de requisição (falha na comunicação com o servidor)
            }
        });

    }
</script>

</body>

</html> -->