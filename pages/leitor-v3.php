<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leitor de QR Code - Staff</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script> -->
    <script src="./js/html15.js" type="text/javascript"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        #reader {
            border-radius: 12px;
            overflow: hidden;
            /* Garante que o vídeo da câmera não vaze das bordas arredondadas */
        }

        #result {
            transition: background-color 0.4s ease, color 0.4s ease;
            min-height: 60px;
            /* Evita que o layout "pule" quando o texto muda */
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1.4;
        }

        .success {
            background-color: #2ECC71;
            color: white;
        }

        .error {
            background-color: #E74C3C;
            color: white;
        }

        .info {
            background-color: #3498DB;
            color: white;
        }

        .waiting {
            background-color: #F1F5F9;
            color: #64748B;
        }
    </style>
</head>

<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-8">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-gray-800">Leitor de Check-in</h1>
                <p class="mt-2 text-gray-500">Aponte a câmera para o QR Code do ingresso.</p>
            </div>

            <div id="reader" class="w-full mt-6"></div>
            <div id="teste"></div>

            <div id="result" class="mt-6 p-4 rounded-lg font-semibold text-center text-lg waiting">
                Aguardando leitura...
            </div>

            <button id="resetButton" class="hidden w-full mt-4 bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                Ler Próximo QR Code
            </button>
        </div>
    </div>

    <footer class="mt-8 text-center text-gray-500 text-sm">
        <p>&copy; 2025 Assissta Conecta. Acesso restrito à equipe.</p>
    </footer>

    <script>
        // --- CONFIGURAÇÃO ---
        const SECRET_API_KEY = 'Ch4v3-P4r4-Meu-Ev3nt0-Te-2025!';
        const API_ENDPOINT_URL = './api_query/checkin_api.php';

        const testeDiv = document.getElementById('teste');
        const resultDiv = document.getElementById('result');
        const readerDiv = document.getElementById('reader');
        const resetButton = document.getElementById('resetButton');
        let html5QrcodeScanner;

        // Função de callback para sucesso na leitura
        const onScanSuccessCallback = (decodedText, decodedResult) => {
            onScanSuccess(decodedText, decodedResult);
        };

        function onScanSuccess(decodedText, decodedResult) {
            // **MODIFICAÇÃO 1: Para e limpa o scanner, desativando a câmera.**
            // O método clear() remove a interface do scanner e para a câmera.
            html5QrcodeScanner.clear().then(_ => {
                console.log("Scanner parado e câmera liberada.");
                readerDiv.style.border = "none"; // Opcional: remove a borda quando a câmera está inativa
            }).catch(error => {
                console.error("Falha ao limpar o scanner.", error);
            });

            resultDiv.textContent = 'Processando...';
            resultDiv.className = 'mt-6 p-4 rounded-lg font-semibold text-center text-lg info';

            try {
                let idToken;
                if (decodedText.includes('?')) {
                    const url = new URL(decodedText);
                    idToken = url.searchParams.get("idtoken");
                } else {
                    idToken = decodedText;
                }

                if (!idToken) {
                    throw new Error("QR Code não contém um 'idtoken' válido.");
                }

                const validationUrl = `${API_ENDPOINT_URL}?idtoken=${idToken}&apiKey=${SECRET_API_KEY}`;
                
                // Limpa a div de teste para não exibir informações antigas na próxima leitura
                testeDiv.textContent = ''; 

                fetch(validationUrl)
                    .then(response => {
                        if (response.status === 200) {
                            resultDiv.className = 'mt-6 p-4 rounded-lg font-semibold text-center text-lg success';
                        } else if (response.status === 409) {
                            resultDiv.className = 'mt-6 p-4 rounded-lg font-semibold text-center text-lg info';
                        } else {
                            resultDiv.className = 'mt-6 p-4 rounded-lg font-semibold text-center text-lg error';
                        }
                        return response.json();
                    })
                    .then(data => {
                        resultDiv.textContent = data.message;
                    })
                    .catch(err => {
                        console.error('Erro na requisição ou ao decodificar JSON:', err);
                        resultDiv.textContent = 'Erro de conexão. Verifique a rede.';
                        resultDiv.className = 'mt-6 p-4 rounded-lg font-semibold text-center text-lg error';
                    })
                    .finally(() => {
                        resetButton.classList.remove('hidden');
                    });

            } catch (e) {
                console.error("Erro ao processar o QR Code:", e.message);
                resultDiv.textContent = 'Formato do QR Code inválido.';
                resultDiv.className = 'mt-6 p-4 rounded-lg font-semibold text-center text-lg error';
                resetButton.classList.remove('hidden');
            }
        }

        /**
         * Função chamada pelo botão para reiniciar o processo de leitura.
         */
        function startScanner() {
            // Esconde o botão novamente
            resetButton.classList.add('hidden');

            // Reseta a mensagem de status
            resultDiv.textContent = 'Aponte para o próximo QR Code.';
            resultDiv.className = 'mt-6 p-4 rounded-lg font-semibold text-center text-lg waiting';
            
            // Limpa a div de teste
            testeDiv.textContent = '';

            // **MODIFICAÇÃO 2: Renderiza e inicia o scanner novamente.**
            // A função render() reinicia a câmera e começa a escanear.
            html5QrcodeScanner.render(onScanSuccessCallback);
        }

        // Adiciona o evento de clique ao botão
        resetButton.addEventListener('click', startScanner);

        // Inicia o scanner quando a página carrega
        document.addEventListener('DOMContentLoaded', () => {
            html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", {
                    fps: 10,
                    qrbox: (width, height) => ({
                        width: Math.min(width, height) * 0.7,
                        height: Math.min(width, height) * 0.7
                    }),
                    rememberLastUsedCamera: true,
                    supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
                },
                false // verbose
            );
            // Inicia o scanner pela primeira vez
            html5QrcodeScanner.render(onScanSuccessCallback);
        });
    </script>
</body>

</html>