<?php
include('../classes/send_certif_mail.php');

// Verifica se a requisição é do tipo POST
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera os dados do formulário (ou da requisição AJAX)
    $nome = 'Maria da Conceição Tavares de Melo';
    $evento = 'Imersão Regulação Emocional em Psicoterapia';
    $palestrante = 'Wilson Vieira Melo';
    $data = 'no dia 24 de maio de 2025';
    $cargaH = '10';
    $local = 'Hotel Luzeiros, em Recife - PE';
    $mail = 'brunojsilva16@gmail.com';
    $localAnexo = '../assets/img/logocheckin.png'; // Caminho fixo para o logo
    $assunto = 'Bem vindo(a), agora você é um(a) PSI CONECTADO(A)!';
    $anexoCorpo = "<p><img src='cid:logocheckin' alt='Imagem Anexada'></p>"; // Corpo padrão

    // Validação básica dos campos obrigatórios (adicione mais conforme necessário)
    // if (empty($nome) || empty($evento) || empty($mail)) {
    //     header('Content-Type: application/json');
    //     echo json_encode(['error' => true, 'message' => 'Por favor, preencha todos os campos obrigatórios.']);
    //     exit();
    // }

    // Instancia a classe responsável por enviar o certificado
    $objeto = new SendCertiftwo(); // Ou SendCertifone, dependendo da sua estrutura

    // Chama o método para enviar o certificado
    $resultado = $objeto->send($nome, $evento, $palestrante, $data, $cargaH, $local, $mail, $localAnexo, $assunto, $anexoCorpo);

    // Define o cabeçalho para JSON
    header('Content-Type: application/json');
    // Envia a resposta JSON para a página solicitante
    echo json_encode($resultado);
    exit();

// } else {
//     // Se a requisição não for POST, retorna um erro JSON
//     header('Content-Type: application/json');
//     echo json_encode(['error' => true, 'message' => 'Método de requisição inválido. Use POST para enviar os dados.']);
//     exit();
// }
    // $mail = $_POST['email'] ?? null;

    // echo json_encode($mail);
?>