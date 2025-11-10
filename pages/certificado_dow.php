<?php
// Verifica se a requisição é para download e se os dados foram enviados via POST
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Padroniza um nome completo para o formato "Primeiras Letras Maiúsculas".
 * Preposições e artigos (de, da, do, e, etc.) são mantidos em minúsculas,
 * exceto quando são a primeira palavra do nome.
 * A função utiliza mb_string para lidar corretamente com acentos (UTF-8).
 *
 * @param string $nome O nome completo a ser formatado.
 * @return string O nome formatado.
 */
function padronizarNomeCompleto($nome)
{
    // Lista de palavras que devem permanecer em minúsculas
    $excecoes = ['e', 'de', 'da', 'do', 'das', 'dos'];

    // 1. Converte toda a string para minúsculas, lidando com acentos
    $nomeEmMinusculo = mb_strtolower($nome, 'UTF-8');

    // 2. Separa a string em um array de palavras
    $palavras = explode(' ', $nomeEmMinusculo);

    $nomeFinal = [];

    // 3. Percorre cada palavra
    foreach ($palavras as $key => $palavra) {
        // 4. Capitaliza a palavra se:
        //    - for a primeira palavra (key === 0)
        //    - OU não estiver na lista de exceções
        if ($key === 0 || !in_array($palavra, $excecoes)) {
            // Pega a primeira letra, converte para maiúscula e concatena com o resto da palavra
            $primeiraLetra = mb_strtoupper(mb_substr($palavra, 0, 1, 'UTF-8'), 'UTF-8');
            $restoDaPalavra = mb_substr($palavra, 1, null, 'UTF-8');
            $nomeFinal[] = $primeiraLetra . $restoDaPalavra;
        } else {
            // 5. Se for uma exceção (e não a primeira palavra), mantém em minúsculas
            $nomeFinal[] = $palavra;
        }
    }

    // 6. Junta as palavras novamente em uma única string
    return implode(' ', $nomeFinal);
}



if (isset($_POST['action']) && $_POST['action'] === 'download') {

    // Carrega as dependências do Dompdf
    // require_once 'dompdf/autoload.inc.php';
    // require __DIR__.'/vendor/autoload.php';


    // Pega as variáveis do POST
    $nomeOriginal = $_POST['nome'] ?? 'Participante';

    // Aplica a padronização
    $nome = trim(padronizarNomeCompleto($nomeOriginal)); // <--- AQUI ESTÁ A MUDANÇA


    // Pega as variáveis do POST enviado pelo JavaScript
    $evento = $_POST['evento'] ?? 'Evento';
    $palestrante = $_POST['palestrante'] ?? 'Palestrante';
    $data = $_POST['data'] ?? 'em data a ser confirmada';
    $cargaH = $_POST['cargah'] ?? '0';
    $local = $_POST['local'] ?? 'local a ser confirmado';

    // Gera um nome de arquivo a partir do primeiro nome
    $temp = explode(" ", $nome);
    $nomeNovo = $temp[0];

    // --- Lógica de Imagem em Base64 (essencial para o PDF funcionar) ---
    $pathToImage = realpath(__DIR__ . '/../assets/tus/certificado.png'); // ou .png
    $imageBase64 = '';

    if ($pathToImage && file_exists($pathToImage)) {
        $type = pathinfo($pathToImage, PATHINFO_EXTENSION);
        $imgData = file_get_contents($pathToImage);
        $imageBase64 = 'data:image/' . $type . ';base64,' . base64_encode($imgData);
    } else {
        die("Erro crítico: A imagem de fundo do certificado não foi encontrada.");
    }

    // HTML do Certificado
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
                    <p>Certificamos que <strong>" . htmlspecialchars($nome) . "</strong>, participou do <strong>" . htmlspecialchars($evento) . "</strong>, 
                    com <strong>" . htmlspecialchars($palestrante) . "</strong>. O evento foi realizado " . htmlspecialchars($data) . ", 
                    " . htmlspecialchars($local) . " com carga horária de <strong>" . htmlspecialchars($cargaH) . " horas</strong>.</p>
                </div>
            </div>
    </body>
    </html>";

    $options = new Options();
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($page);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    // --- PONTO CHAVE PARA O DOWNLOAD ---
    // A opção "Attachment" => true força o navegador a abrir a caixa de diálogo de download.
    $dompdf->stream(
        "certificado-{$nomeNovo}.pdf",
        array("Attachment" => true)
    );
    exit; // Termina o script após enviar o PDF
}

// Se não for uma ação de download, pode colocar um 'else' aqui ou simplesmente não fazer nada.
// echo "Ação inválida.";