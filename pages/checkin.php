<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso Negado</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md mx-auto bg-white rounded-xl shadow-lg p-8 text-center">
        
        <!-- Ícone de Acesso Negado (SVG) -->
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100">
            <svg class="h-10 w-10 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
            </svg>
        </div>

        <h1 class="mt-6 text-2xl font-bold text-gray-800">
            Acesso Não Autorizado
        </h1>

        <p class="mt-3 text-gray-600">
            Apresente esse Qrcode ao time do Assista Conecta para realização do check-in no dia do evento.
        </p>

        <!-- <div class="mt-8">
            <a href="javascript:history.back()" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">
                &larr; Voltar para a página anterior
            </a>
        </div> -->

    </div>

</body>
</html>
