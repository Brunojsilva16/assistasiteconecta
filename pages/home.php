
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assista Conecta - Novidades em Breve</title>
    <!-- Incluindo o Tailwind CSS para estilização rápida e responsiva -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Importando a fonte Inter do Google Fonts para consistência com o design moderno -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800&display=swap" 
    rel="stylesheet">
    <link rel="icon" href="./assets/img/favicon_conecta.png" sizes="32x32">
    <style>
        /* Definindo a fonte principal para o corpo do documento */
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Container principal que centraliza o banner na tela -->
    <div class="min-h-screen flex items-center justify-center p-4">
        
        <!-- Card do Banner -->
        <div class="w-full max-w-3xl bg-white rounded-xl shadow-lg overflow-hidden text-center transition-transform duration-300 hover:scale-105 hover:shadow-2xl">
            
            <!-- Seção do Logo -->
            <div class="p-8 bg-white">
                 <!-- Usando o logo oficial do site para manter a identidade da marca -->
                 <img src="./assets/img/conecta2.png" alt="Logo Assista Conecta" class="h-24 mx-auto" onerror="this.onerror=null; this.src='https://placehold.co/200x50/E5E7EB/9CA3AF?text=Logo';">
            </div>

            <!-- Seção Principal do Banner com gradiente e texto -->
            <div class="bg-gradient-to-r from-[#F9A825] to-[#EF6C00] p-10 relative">
                
                <!-- Círculos decorativos que remetem ao logo, adicionando um toque visual -->
                <div class="absolute top-0 left-0 w-24 h-24 bg-[#D32F2F]/20 rounded-full -translate-x-1/4 -translate-y-1/4" aria-hidden="true"></div>
                <div class="absolute bottom-0 right-0 w-40 h-40 bg-[#D32F2F]/20 rounded-full translate-x-1/4 translate-y-1/4" aria-hidden="true"></div>
                
                <!-- Título principal do anúncio -->
                <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight drop-shadow-sm mb-4 relative">
                    Vem novidade por aí!
                </h1>
                
                <!-- Texto secundário com a mensagem completa -->
                <p class="text-lg md:text-xl text-white/90 max-w-xl mx-auto relative">
                    Em breve teremos <span class="font-bold">novos eventos</span> e um <span class="font-bold">site novinho</span> para você aproveitar. Fique de olho!
                </p>
            </div>
            
            <!-- Seção do Instagram -->
            <div class="bg-gray-50 p-6 border-t border-gray-200">
                <p class="text-gray-600 mb-3">Siga-nos no Instagram para não perder nenhuma novidade!</p>
                <!-- Link para o perfil do Instagram, que abre em uma nova aba -->
                <a href="https://www.instagram.com/assista_clinica" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-gray-800 font-bold hover:text-[#EF6C00] transition-colors duration-300">
                    <!-- Ícone do Instagram em SVG para melhor qualidade visual -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                    <span>@assista_clinica</span>
                </a>
            </div>
        </div>
    </div>
</body>
</html>



