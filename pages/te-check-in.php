<?php


define('SECRET_API_KEY', 'Ch4v3-P4r4-Meu-Ev3nt0-Te-2025!');
header('Content-Type: application/json');

// --- LÓGICA DE VALIDAÇÃO ---

// 1. VERIFICAÇÃO DA CHAVE DE API
// O leitor envia a chave como um parâmetro GET.
$submittedApiKey = $_GET['apikey'] ?? null;
if ($submittedApiKey !== SECRET_API_KEY) {
    http_response_code(401); // Unauthorized
    echo json_encode(['status' => 'error', 'message' => 'Acesso não autorizado. Chave inválida.']);
    exit;
}

// 2. OBTER O TOKEN DO INGRESSO
// O token vem do QR Code, no parâmetro 'ticket'.
$token = $_GET['idticket'] ?? null;
if (!$token) {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Token do ingresso não fornecido.']);
    exit;
}

?>

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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.all.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


<script>
    $(document).ready(function() {

        chamadaChck();

        function chamadaChck() {

            var qrid = '<?php echo $token; ?>';
            

            $.ajax({
                method: 'POST',
                url: './api_query/fetch_credenc.php',
                data: {
                    idtoken: qrid
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
                            confirmButtonColor: "#198754",
                            // timer: 2000,
                            willClose: () => {
                                if (response.envio) {
                                    // enviaCheck_in(response.nome, response.email);
                                    console.log('email teste disparado!' + ' ' + response.email);
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

</script>

</body>

</html>