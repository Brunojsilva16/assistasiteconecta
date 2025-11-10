<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Sorteio</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/sorteio1080.css">
    <link rel="icon" href="./assets/img/favicon.png" sizes="32x32">
    <style>
        /* Estilos adicionados para ajustar o layout */
        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            overflow: hidden;
            /* Evita barras de rolagem indesejadas */
        }

        #main-wrapper {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        #sorteio-area {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            /* Alinha logos no topo */
            align-items: center;
            text-align: center;
            padding: 20px;
            position: relative;
            /* background-image: url('./assets/te/te-capa.jpg'); */
            background-size: cover;
            background-position: center top;
            background-repeat: no-repeat;
            /* OPACIDADE REMOVIDA DAQUI PARA NÃO AFETAR O TEXTO */
        }

        #sorteio-area::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
            /* NOVA CAMADA ESCURA PARA MELHORAR CONTRASTE */
            /* background-color: rgba(0, 0, 0, 0.7); */
        }

        /* --- CSS PARA AS LOGOS --- */
        #header-logos {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 2vh 3vw;
            box-sizing: border-box;
            position: absolute;
            /* Posição absoluta para ficar no topo */
            top: 0;
            left: 0;
            z-index: 3;
            /* Aumentado para ficar sobre a camada escura */
        }

        .logo-img {
            max-height: 80px;
            width: auto;
        }

        /* --- FIM DO CSS DAS LOGOS --- */

        #sorteio-content {
            position: relative;
            z-index: 2;
            /* Garante que o conteúdo fique sobre a camada escura */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
            /* Ocupa toda a altura da área de sorteio */
        }

        #resultadoSorteio {
            font-size: 6em;
            font-weight: 700;
            /* SOMBRA DO TEXTO REFORÇADA PARA MAIOR DESTAQUE */
            text-shadow: 0 0 15px rgba(0, 0, 0, 0.8), 0 0 5px rgba(0, 0, 0, 1);
            color: #d9c19d;
            /* Tom de bege/marrom */
        }

        #textoPremio {
            font-size: 2.5em;
            margin-top: 10px;
            color: #FFF;
            /* Cor alterada para branco para melhor contraste */
            text-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
        }

        #lista-sorteados-area {
            width: 350px;
            flex-shrink: 0;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            box-shadow: -5px 0px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        #lista-sorteados-area h2 {
            text-align: center;
            color: #333;
            margin-top: 0;
            border-bottom: 2px solid #f2994a;
            padding-bottom: 10px;
        }

        #listaSorteados {
            list-style: none;
            padding: 0;
            margin: 0;
            overflow-y: auto;
            flex-grow: 1;
        }

        #listaSorteados li {
            background-color: #d9c19d75;
            padding: 12px 15px;
            margin-bottom: 8px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            font-size: 1.1em;
            color: #555;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #sortearBtn {
            position: relative;
            left: 50%;
            transform: translateX(-50%);
            padding: 14px 25px;
            margin-top: 12px;
            font-size: 1.2em;
            font-weight: 700;
            background-color: #000;
            color: white;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            text-transform: uppercase;
            z-index: 1000;
            letter-spacing: 2px;
        }

        #sortearBtn:hover {
            background-color: #ff8d2d;
            transform: translateX(-50%) scale(1.05);
        }
    </style>
</head>

<body>


    <div id="main-wrapper">

        <div id="sorteio-area">
            <div id="header-logos">
                <!-- <img src="./assets/te/te-logo.png" alt="Logo Instituto Português de Terapia do Esquema" class="logo-img"> -->
                <img src="./assets/te/te-conecta.png" alt="Logo Assista Conecta" class="logo-img">
            </div>
            <div id="sorteio-content">
                <div id="resultadoSorteio"></div>
                <div id="textoPremio">Você ganhou!!!</div>
            </div>
        </div>

        <div id="lista-sorteados-area">
            <h2>Sorteados</h2>
            <ul id="listaSorteados">
            </ul>
            <button id="sortearBtn">Sortear Nome</button>
        </div>
    </div>

    <script>
        // SEU SCRIPT JAVASCRIPT CONTINUA IGUAL AQUI
        const sortearBtn = document.getElementById('sortearBtn');
        const resultadoSorteio = document.getElementById('resultadoSorteio');
        const textoPremio = document.getElementById('textoPremio');
        const listaSorteados = document.getElementById('listaSorteados');

        sortearBtn.addEventListener('click', async () => {
            resultadoSorteio.classList.remove('show');
            resultadoSorteio.textContent = '';
            textoPremio.classList.remove('show');

            const urlApiSorteio = './api_query/fetch_sorteio_all.php';
            const formDataSend = new FormData();
            formDataSend.append('action', 'sortear');

            await new Promise(resolve => setTimeout(resolve, 500));

            resultadoSorteio.textContent = 'Sorteando...';
            resultadoSorteio.style.fontSize = '3.5em';
            resultadoSorteio.style.filter = 'blur(8px)';
            resultadoSorteio.classList.add('show');

            try {
                const response = await fetch(urlApiSorteio, {
                    method: 'POST',
                    body: formDataSend
                });
                const data = await response.json();

                if (data.success) {
                    let minhaString = data.telefone;
                    let quatroUltimos = minhaString.slice(-4);

                    resultadoSorteio.textContent = data.nomeSorteado;
                    resultadoSorteio.style.fontSize = '6em';
                    resultadoSorteio.style.filter = 'blur(0)';
                    resultadoSorteio.classList.add('show');
                    textoPremio.classList.add('show');

                    const novoItem = document.createElement('li');
                    novoItem.textContent = data.nomeSorteado + ' - XXXXX ' + quatroUltimos;
                    listaSorteados.prepend(novoItem);

                } else {
                    resultadoSorteio.textContent = data.message || data.error || 'Erro desconhecido ao sortear.';
                    resultadoSorteio.style.fontSize = '3em';
                    resultadoSorteio.style.filter = 'blur(0)';
                    resultadoSorteio.classList.add('show');
                    textoPremio.classList.remove('show');
                }
            } catch (error) {
                console.error('Erro na requisição:', error);
                resultadoSorteio.textContent = 'Erro de conexão com o servidor.';
                resultadoSorteio.style.fontSize = '3em';
                resultadoSorteio.style.filter = 'blur(0)';
                resultadoSorteio.classList.add('show');
                textoPremio.classList.remove('show');
            }
        });
    </script>
</body>

</html>