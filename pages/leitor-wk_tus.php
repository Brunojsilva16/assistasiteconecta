<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leitor de QR Code - Staff</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        }

        #result {
            transition: background-color 0.4s ease, color 0.4s ease;
            min-height: 100px;
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

        /* --- ESTILOS DAS ANIMAÇÕES (COM CSS MAIS ESPECÍFICO) --- */

        .animation-container {
            display: none;
            margin: auto;
            height: 60px;
            width: 60px;
        }

        /* Animação de Sucesso (Checkmark) */
        #success-animation .checkmark {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: block;
            stroke-width: 3;
            stroke: #fff;
            stroke-miterlimit: 10;
            margin: auto;
            animation: scale .3s ease-in-out .9s both;
        }

        #success-animation .checkmark__circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 3;
            stroke-miterlimit: 10;
            stroke: #fff;
            animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }

        #success-animation .checkmark__check {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
        }

        /* Animação de Erro (X) */
        #error-animation .cross {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: block;
            stroke-width: 3;
            stroke: #fff;
            stroke-miterlimit: 10;
            margin: auto;
            animation: scale .3s ease-in-out .9s both;
        }

        #error-animation .cross__circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 3;
            stroke-miterlimit: 10;
            stroke: #fff;
            animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }

        #error-animation .cross__path {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
        }

        @keyframes stroke {
            100% {
                stroke-dashoffset: 0;
            }
        }

        @keyframes scale {

            0%,
            100% {
                transform: none;
            }

            50% {
                transform: scale3d(1.1, 1.1, 1);
            }
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

                <div id="success-animation" class="animation-container">
                    <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52" fill="none">
                        <circle class="checkmark__circle" cx="26" cy="26" r="25" />
                        <path class="checkmark__check" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                    </svg>
                </div>

                <div id="error-animation" class="animation-container">
                    <svg class="cross" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52" fill="none">
                        <circle class="cross__circle" cx="26" cy="26" r="25" />
                        <path class="cross__path" d="M16 16L36 36 M36 16L16 36" />
                    </svg>
                </div>
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
        const SECRET_API_KEY = 'Ch4v3-P4r4-Meu-Ev3nt0-Te-2025!';
        const API_ENDPOINT_URL = './api_query/checkin_api.php';

        const resultDiv = document.getElementById('result');
        const readerDiv = document.getElementById('reader');
        const resetButton = document.getElementById('resetButton');
        let html5QrcodeScanner;

        const onScanSuccessCallback = (decodedText, decodedResult) => {
            onScanSuccess(decodedText, decodedResult);
        };

        function onScanSuccess(decodedText, decodedResult) {
            html5QrcodeScanner.clear().then(_ => {
                console.log("Scanner parado e câmera liberada.");
                readerDiv.style.border = "none";
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
                    apiTable = "workshop_tus";
                } else {
                    idToken = decodedText;
                    apiTable = "";
                }

                if (!idToken) {
                    throw new Error("QR Code não contém um 'idtoken' válido.");
                }

                const validationUrl = `${API_ENDPOINT_URL}?idtoken=${idToken}&apiKey=${SECRET_API_KEY}&apiTable=${apiTable}`;

                const successAnimation = document.getElementById('success-animation');
                const errorAnimation = document.getElementById('error-animation');

                fetch(validationUrl)
                    .then(response => {
                        return response.json().then(data => ({
                            status: response.status,
                            data: data
                        }));
                    })
                    .then(({
                        status,
                        data
                    }) => {
                        let animationToShow = null;

                        const baseClasses = 'mt-6 p-4 rounded-lg font-semibold text-center text-lg';

                        if (status === 200) {
                            resultDiv.className = `${baseClasses} success`;
                            animationToShow = successAnimation;
                        } else if (status === 409) {
                            resultDiv.className = `${baseClasses} info`;
                            animationToShow = successAnimation;
                        } else {
                            resultDiv.className = `${baseClasses} error`;
                            animationToShow = errorAnimation;
                        }

                        resultDiv.textContent = '';
                        if (animationToShow) {
                            animationToShow.style.display = 'block';
                        }

                        setTimeout(() => {
                            if (animationToShow) {
                                animationToShow.style.display = 'none';
                            }
                            resultDiv.textContent = data.message;
                        }, 1500);
                    })
                    .catch(err => {
                        console.error('Erro na requisição ou ao decodificar JSON:', err);
                        const baseClasses = 'mt-6 p-4 rounded-lg font-semibold text-center text-lg';
                        resultDiv.className = `${baseClasses} error`;
                        resultDiv.textContent = '';
                        errorAnimation.style.display = 'block';
                        setTimeout(() => {
                            errorAnimation.style.display = 'none';
                            resultDiv.textContent = 'Erro de conexão. Verifique a rede.';
                        }, 1500);
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

        function startScanner() {
            resetButton.classList.add('hidden');
            resultDiv.textContent = 'Aponte para o próximo QR Code.';
            resultDiv.className = 'mt-6 p-4 rounded-lg font-semibold text-center text-lg waiting';
            html5QrcodeScanner.render(onScanSuccessCallback);
        }

        resetButton.addEventListener('click', startScanner);

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
                false
            );
            html5QrcodeScanner.render(onScanSuccessCallback);
        });
    </script>
</body>

</html>