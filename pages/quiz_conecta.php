<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Super Quiz Interativo Conecta</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --cor-facil: #2ecc71;
      --cor-facil-hover: #27ae60;
      --cor-medio: #3498db;
      --cor-medio-hover: #2980b9;
      --cor-dificil: #e67e22;
      --cor-dificil-hover: #d35400;
      --cor-correta: #1abc9c;
      --cor-incorreta: #e74c3c;
      --cor-texto: #ffffff;
      --cor-sombra: rgba(0, 0, 0, 0.1);
      --cor-resultado: #333;
      --cor-resultado-hover: #d35400;
    }

    body {
      font-family: 'Poppins', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
      /* Ajustei o gradiente para algo mais próximo do laranja/vermelho da imagem de exemplo */
      background: linear-gradient(136deg, #e67e22a6, #cb1907);
      color: #333;
      padding: 20px;
      box-sizing: border-box;
    }


    /* Estilos para o formulário (inspirado na sua imagem) */
    #form-container {
      padding: 20px 0;
      text-align: left;
    }

    #form-container h2 {
      color: #2c3e50;
      margin-bottom: 25px;
      font-weight: 700;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      font-weight: 600;
      margin-bottom: 5px;
      color: #333;
    }

    #participante-form input[type="text"],
    #participante-form input[type="email"] {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      box-sizing: border-box;
      font-size: 1em;
    }

    .submit-btn {
      /* Cor do botão Laranja/Vermelho da sua imagem */
      background: linear-gradient(to right, #ff9933, #e74c3c);
      color: var(--cor-texto);
      font-weight: 700;
      font-size: 1.1em;
      padding: 15px 30px;
      margin-top: 20px;
      width: 100%;
    }

    .submit-btn:hover {
      background: linear-gradient(to right, #ffb166, #ff6b5b) !important;
    }

    /* Esconde os elementos do quiz por padrão */
    #step,
    #quiz,
    #resultado {
      display: none;
    }

    /* ESTILOS PARA AS LOGOS (NOVO) */
    #logo-esquerda,
    #logo-direita {
      position: absolute;
      top: 30px;
      /* Ajuste a distância do topo */
      z-index: 10;
      /* Garante que as logos fiquem acima do fundo */
    }

    #logo-esquerda {
      left: 30px;
      /* Distância da esquerda */
    }

    #logo-direita {
      right: 30px;
      /* Distância da direita */
    }

    .logo-img {
      max-width: 180px;
      /* Ajuste o tamanho máximo da logo */
      height: auto;
      display: block;
      /* Garante que a imagem se comporte corretamente */
    }

    /* FIM ESTILOS LOGOS */

    #quiz-container {
      background-color: white;
      padding: 30px 40px;
      border-radius: 20px;
      box-shadow: 0 10px 30px var(--cor-sombra);
      width: 100%;
      max-width: 600px;
      text-align: center;
      transition: all 0.3s ease;
    }

    h1 {
      margin-top: 0;
      color: #2c3e50;
      font-weight: 700;
    }

    #step {
      font-size: 1.1em;
      font-weight: 600;
      color: #7f8c8d;
      margin-bottom: 25px;
      min-height: 25px;
    }

    #quiz {
      opacity: 1;
      transform: scale(1);
      transition: opacity 0.4s ease-out, transform 0.4s ease-out;
    }

    #quiz.loading {
      opacity: 0;
      transform: scale(0.95);
    }

    .question {
      font-size: 1.5em;
      font-weight: 600;
      margin-bottom: 30px;
      min-height: 80px;
    }

    .alternativas-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 15px;
    }

    .alternativa {
      display: block;
      width: 100%;
      padding: 18px 20px;
      font-size: 1.2em;
      letter-spacing: 2px;
      font-weight: 600;
      color: var(--cor-texto);
      border: none;
      border-radius: 12px;
      cursor: pointer;
      transition: all 0.2s ease-in-out;
      box-shadow: 0 4px 15px var(--cor-sombra);
    }

    .alternativa:hover:not(:disabled) {
      transform: translateY(-3px) scale(1.02);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .alternativa:disabled {
      cursor: not-allowed;
      opacity: 0.7;
    }

    #resultado {
      margin-top: 25px;
    }

    #resultado button {
      background-color: var(--cor-resultado);
    }

    #resultado button:hover {
      background-color: var(--cor-resultado-hover);
    }

    /* Cores por nível */
    .level-facil .alternativa {
      background-color: var(--cor-facil);
    }

    .level-facil .alternativa:hover:not(:disabled) {
      background-color: var(--cor-facil-hover);
    }

    .level-medio .alternativa {
      background-color: var(--cor-medio);
    }

    .level-medio .alternativa:hover:not(:disabled) {
      background-color: var(--cor-medio-hover);
    }

    .level-dificil .alternativa {
      background-color: var(--cor-dificil);
    }

    .level-dificil .alternativa:hover:not(:disabled) {
      background-color: var(--cor-dificil-hover);
    }

    /* Animações de resposta */
    .alternativa.correct {
      animation: pulse-correct 0.8s ease;
      background-color: var(--cor-correta) !important;
    }

    .alternativa.incorrect {
      animation: shake-incorrect 0.6s ease;
      background-color: var(--cor-incorreta) !important;
    }

    .final-message {
      font-size: 1.8em;
      font-weight: 700;
      margin-bottom: 15px;
    }

    .final-message.success {
      color: var(--cor-correta);
    }

    .final-message.game-over {
      color: var(--cor-incorreta);
    }

    @keyframes pulse-correct {

      0%,
      100% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.05);
      }
    }

    @keyframes shake-incorrect {

      0%,
      100% {
        transform: translateX(0);
      }

      10%,
      30%,
      50%,
      70%,
      90% {
        transform: translateX(-8px);
      }

      20%,
      40%,
      60%,
      80% {
        transform: translateX(8px);
      }
    }

    @media (max-width: 640px) {
      #quiz-container {
        padding: 20px;
      }

      h1 {
        font-size: 1.8em;
      }

      .question {
        font-size: 1.2em;
        min-height: 60px;
      }

      .final-message {
        font-size: 1.5em;
      }

      /* Ajustes para as logos em telas pequenas (NOVO) */
      #logo-esquerda,
      #logo-direita {
        top: 15px;
      }

      #logo-esquerda {
        left: 15px;
      }

      #logo-direita {
        right: 15px;
      }

      .logo-img {
        max-width: 100px;
        /* Reduz o tamanho em telas menores */
      }
    }
  </style>
</head>

<body>

  <div id="logo-esquerda">
    <img src="./assets/img/logo01.png" alt="Logo Workshop" class="logo-img">
  </div>

  <div id="logo-direita">
    <img src="./assets/img/conecta2.png" alt="Logo Conecta" class="logo-img">
  </div>

  <div id="quiz-container">
    <h1>Super Quiz Interativo Conecta</h1>

    <div id="form-container" style="display: none;">
      <h2 id="form-title">Verificação de Acesso</h2>
      <div id="aviso-cadastro" style="display: none; color: #3498db; margin-bottom: 15px; font-weight: 600;"></div>

      <form id="participante-form">

        <div class="form-group" id="step-email">
          <label for="email">E-MAIL: *</label>
          <input type="email" id="email" name="email" placeholder="E-mail" required>
        </div>

        <div id="step-restante" style="display: none;">
          <div class="form-group">
            <label for="nome">NOME: *</label>
            <input type="text" id="nome" name="nome" placeholder="Nome" required>
          </div>
          <div class="form-group">
            <label for="telefone">TELEFONE: *</label>
            <input type="text" id="telefone" name="telefone" placeholder="(00) 00000-0000" maxlength="15" required>

          </div>
        </div>

        <button type="button" id="btn-avancar" class="alternativa submit-btn">
          AVANÇAR &rarr;
        </button>
        <button type="submit" id="btn-cadastrar" class="alternativa submit-btn" style="display: none;">
          CADASTRAR &rarr;
        </button>
      </form>
    </div>
    <div id="step"></div>
    <div id="quiz"></div>
    <div id="resultado"></div>
  </div>

  <script>
    let perguntas = [];
    let perguntaAtual = 0;
    let emailVerificado = false; // Novo: Controla o estado do formulário

    const quizDiv = document.getElementById("quiz");
    const stepDiv = document.getElementById("step");
    const resultadoDiv = document.getElementById("resultado");
    const formContainer = document.getElementById("form-container");

    const participanteForm = document.getElementById("participante-form");
    const btnAvancar = document.getElementById("btn-avancar");
    const btnCadastrar = document.getElementById("btn-cadastrar");
    const stepRestante = document.getElementById("step-restante");
    const formTitle = document.getElementById("form-title");
    const avisoCadastro = document.getElementById("aviso-cadastro");
    const inputTelefone = document.getElementById('telefone'); // <-- CORREÇÃO AQUI!



    let participanteLogado = false;

    // =========================================================================
    // FUNÇÃO DE MÁSCARA DE TELEFONE (NOVO)
    // =========================================================================
    function maskTelefone(value) {
      if (!value) return "";
      value = value.replace(/\D/g, ""); // Remove tudo que não for dígito
      value = value.replace(/^(\d{2})(\d)/g, "($1) $2"); // Coloca parênteses em volta dos dois primeiros dígitos
      value = value.replace(/(\d)(\d{4})$/, "$1-$2"); // Coloca hífen antes dos últimos 4 dígitos
      return value;
    }

    // Aplica a máscara no campo de telefone
    inputTelefone.addEventListener('input', function(e) {
      e.target.value = maskTelefone(e.target.value);
    });
    // =========================================================================
    // FIM MÁSCARA
    // =========================================================================


    // Oculta o quiz e mostra o formulário ao iniciar
    function iniciarApp() {
      // Reseta o formulário
      participanteForm.reset();
      formTitle.innerText = "Verificação de Acesso";
      avisoCadastro.style.display = 'none';
      stepRestante.style.display = 'none';
      btnAvancar.style.display = 'block';
      btnCadastrar.style.display = 'none';
      emailVerificado = false;

      // ---> ADICIONE ESTAS DUAS LINHAS <---
      btnAvancar.disabled = false;
      btnAvancar.innerText = 'AVANÇAR →';

      // Mostra o formulário e esconde o quiz
      formContainer.style.display = 'block';
      stepDiv.style.display = 'none';
      quizDiv.style.display = 'none';
      resultadoDiv.style.display = 'none';
    }


    // =========================================================================
    // LÓGICA DE AVANÇO (Verificação de E-mail)
    // =========================================================================
    btnAvancar.addEventListener('click', async function() {
      const email = document.getElementById('email').value.trim();
      if (!email || !email.includes('@')) {
        alert("Por favor, insira um e-mail válido.");
        return;
      }

      btnAvancar.disabled = true;
      btnAvancar.innerText = 'VERIFICANDO...';

      try {
        // Requisição GET para verificar se o e-mail existe
        const response = await fetch(`./api_query/salvar_participante.php?email=${encodeURIComponent(email)}`);
        const data = await response.json();

        if (data.status === 'exists') {
          // E-mail existente: Mostra aviso e vai direto para o quiz
          participanteLogado = true;
          avisoCadastro.innerHTML = `Olá, **${data.participante_nome}**! Você já tem cadastro.`;
          avisoCadastro.style.display = 'block';

          setTimeout(() => {
            iniciarQuiz();
          }, 2000); // Aguarda 2s para o usuário ver o aviso

        } else if (data.status === 'new') {
          // E-mail novo: Avança para a segunda etapa do formulário
          emailVerificado = true;
          formTitle.innerText = "Complete seu Cadastro";
          stepRestante.style.display = 'block';
          btnAvancar.style.display = 'none';
          btnCadastrar.style.display = 'block';
          document.getElementById('nome').focus(); // Foca no próximo campo
        } else {
          alert("Erro na verificação: " + data.message);
        }
      } catch (error) {
        console.error("Erro ao verificar e-mail:", error);
        alert("Erro de conexão com o servidor.");
      } finally {
        btnAvancar.disabled = false;
        btnAvancar.innerText = 'AVANÇAR →';
      }
    });

    // =========================================================================
    // LÓGICA DE CADASTRO (Envio de Nome/Telefone)
    // =========================================================================
    participanteForm.addEventListener('submit', async function(e) {
      e.preventDefault();

      if (!emailVerificado) return; // Só deve processar se o e-mail foi verificado

      const nome = document.getElementById('nome').value.trim();
      const email = document.getElementById('email').value.trim();
      const telefone = document.getElementById('telefone').value.trim();

      if (!nome || !telefone) {
        alert("Nome e Telefone são obrigatórios para o cadastro.");
        return;
      }

      btnCadastrar.disabled = true;
      btnCadastrar.innerText = 'CADASTRANDO...';

      try {
        const response = await fetch("./api_query/salvar_participante.php", {
          method: "POST",
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            nome,
            email,
            telefone
          })
        });
        const data = await response.json();

        if (data.success) {
          participanteLogado = true;
          iniciarQuiz();
        } else {
          alert("Erro no cadastro: " + data.message);
          btnCadastrar.disabled = false;
          btnCadastrar.innerText = 'CADASTRAR →';
        }
      } catch (error) {
        console.error("Erro ao conectar com o servidor:", error);
        alert("Erro de conexão ao salvar os dados. Tente novamente.");
        btnCadastrar.disabled = false;
        btnCadastrar.innerText = 'CADASTRAR →';
      }
    });

    // Funções de controle do Quiz
    function iniciarQuiz() {
      formContainer.style.display = 'none';
      stepDiv.style.display = 'block';
      quizDiv.style.display = 'block';
      resultadoDiv.style.display = 'none';
      carregarPerguntas();
    }

    async function carregarPerguntas() {
      if (!participanteLogado) return; // Garante que só carrega se estiver logado

      try {
        const response = await fetch("./api_query/fetch_quiz.php");
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();

        if (data.error) {
          quizDiv.innerHTML = `<p>Erro: ${data.message}</p>`;
          return;
        }

        perguntas = data;
        mostrarPergunta();
      } catch (err) {
        quizDiv.innerHTML = `<p>Ocorreu um erro ao carregar as perguntas. Tente novamente mais tarde.</p>`;
        console.error("Erro de conexão:", err);
      }
    }

    // Função para salvar a conclusão (inalterada)
    async function salvarConclusaoQuiz() {
      try {
        // ATENÇÃO: Verifique se o caminho está correto
        await fetch("./api_query/concluir_quiz.php");
      } catch (error) {
        console.error("Erro ao salvar a conclusão do quiz:", error);
      }
    }

    function mostrarPergunta() {
      quizDiv.classList.add('loading');

      setTimeout(() => {
        if (perguntaAtual >= perguntas.length) {
          salvarConclusaoQuiz(); // Chama a função ao concluir

          // Exibe a tela final
          quizDiv.innerHTML = `<h2 class="final-message success">🎉 Parabéns! Você concluiu o quiz!</h2>`;
          stepDiv.innerHTML = "Você acertou todas as perguntas!";
          resultadoDiv.style.display = 'block';
          resultadoDiv.innerHTML = `<button class="alternativa" onclick="reiniciarQuiz()">Jogar Novamente</button>`;
          quizDiv.classList.remove('loading');
          return;
        }
        // ... (restante do código para mostrar a pergunta atual, inalterado) ...
        const p = perguntas[perguntaAtual];
        quizDiv.className = `level-${p.nivel}`;
        stepDiv.innerText = `Pergunta ${perguntaAtual + 1} de ${perguntas.length}`;

        let html = `
                    <div class="question">${p.pergunta}</div>
                    <div class="alternativas-grid">
                `;

        for (let i = 1; i <= 4; i++) {
          html += `<button class="alternativa" onclick="verificarResposta(event, ${i}, ${p.correta})">${p['alternativa'+i]}</button>`;
        }
        html += `</div>`;
        quizDiv.innerHTML = html;
        quizDiv.classList.remove('loading');
      }, 400);
    }

    // ... (função verificarResposta, inalterada) ...
    function verificarResposta(event, escolhida, correta) {
      const botoes = quizDiv.querySelectorAll('.alternativa');
      const botaoClicado = event.target;

      botoes.forEach(botao => {
        botao.disabled = true;
      });

      if (escolhida == correta) {
        botaoClicado.classList.add('correct');
        setTimeout(() => {
          perguntaAtual++;
          mostrarPergunta();
        }, 1200);
      } else {
        // Marca a resposta errada (vermelho)
        botaoClicado.classList.add('incorrect');

        // Com a correção acima, este laço agora funcionará corretamente
        // para marcar a resposta certa (verde).
        botoes.forEach((botao, index) => {
          if ((index + 1) == correta) {
            botao.classList.add('correct');
          }
        });

        // Após um tempo, mostra o resultado final ABAIXO da pergunta
        setTimeout(() => {
          const acertos = perguntaAtual;
          const totalPerguntas = perguntas.length;

          const porcentagem = totalPerguntas > 0 ? (acertos / totalPerguntas) * 100 : 0;
          let mensagemFinal = '';
          let fimjogo = 'Fim de jogo!'


          if (porcentagem < 30) {
            mensagemFinal = 'Não foi dessa vez, ' + fimjogo;
          } else if (porcentagem < 50) {
            mensagemFinal = 'Você foi bem, ' + fimjogo;
          } else if (porcentagem < 70) {
            mensagemFinal = 'Chegou perto, ' + fimjogo;
          } else {
            mensagemFinal = 'Foi por pouco! Você tem um ótimo conhecimento, ' + fimjogo;
          }


          // Atualiza o texto do passo para o placar final
          stepDiv.innerHTML = `Você acertou ${acertos} de ${totalPerguntas}.`;

          // Adiciona a mensagem e o botão de reiniciar no 'resultadoDiv'
          resultadoDiv.style.display = 'block';
          resultadoDiv.innerHTML = `
              <h2 class="final-message game-over">❌  ${mensagemFinal}</h2>
              <hr>
              <button class="alternativa" onclick="reiniciarQuiz()">Jogar Novamente</button>
            `;
        }, 1500); // Aguarda 1.5s para o usuário ver o feedback da questão
      }
    }

    function reiniciarQuiz() {
      perguntaAtual = 0;
      resultadoDiv.innerHTML = "";
      quizDiv.innerHTML = "";
      participanteLogado = false;
      iniciarApp(); // Volta para o formulário de e-mail
    }

    // Inicializa a aplicação
    iniciarApp();
  </script>

</body>

</html>