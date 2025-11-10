<?php

use LoginstatusMaster\LoginM;

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataLoginM.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

if (!empty($_SESSION['acesso'])) {

  $login = new LoginM();

  if ($login->isLoggedIn()) {
    $usuario = $login->getUserData(); // Obtém dados do usuário logado
    $image = './assets/img/sem-foto.png';
  } else {
    header('Location: login');
    exit();
  }
} else {
  header('Location: login');
  exit();
}


function firstName($name)
{
  $array = explode(" ", $name);
  return $array[0];
}
// echo print_r($usuario);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <title>Attendance Dashboard | By Code Info</title>
  <link rel="stylesheet" href="./css/dash_newsh.css" />
  <link rel="stylesheet" href="./css/dash_painelone.css" />
  <link rel="stylesheet" href="./css/dash_indexds.css" />
  <link rel="stylesheet" href="./css/dash_show_loadds.css" />
  <link rel="stylesheet" href="./css/dash_botoesdsv1.css" />

  <!-- Font Awesome Cdn Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js" integrity="sha512-01CJ9/g7e8cUmY0DFTMcUw/ikS799FHiOA0eyHsUWfOetgbx/t6oV4otQ5zXKQyIrQGTHSmRVPIgrgLcZi/WMA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <link rel="icon" href="./assets/img/favicon.png" sizes="32x32">
</head>


<body>

  <?php

  /**
   * Verifica se um usuário pode acessar uma determinada tabela/página.
   *
   * @param string $tabela O nome da tabela/página a ser verificada (ex: 'inscricao').
   * @param object|array $usuario O objeto ou array com os dados do usuário logado.
   * @param array $permissoesGerais O array com as regras de permissão.
   * @return bool Retorna true se o acesso for permitido, false caso contrário.
   */
  function podeAcessar($tabela, $usuario, $permissoesGerais)
  {
    // Garante que os dados do usuário existam
    $nivelAcessoUsuario = $usuario['acesso'] ?? 0;
    $permissoesUsuario = explode(',', $usuario['permissao'] ?? '');

    // 1. VERIFICAÇÃO DE PERMISSÃO EXPLÍCITA:
    // Se a tabela está listada diretamente nas permissões do usuário, concede acesso.
    if (in_array($tabela, $permissoesUsuario)) {
      return true;
    }

    // Se não há uma regra geral para esta tabela, nega o acesso por segurança.
    if (!isset($permissoesGerais[$tabela])) {
      return false;
    }

    $regra = $permissoesGerais[$tabela];

    // 2. VERIFICAÇÃO PELAS REGRAS GERAIS:
    // Se a regra for um número (nível de acesso)
    if (is_int($regra)) {
      return $nivelAcessoUsuario >= $regra;
    }

    // Se a regra for uma string (papel/role)
    if (is_string($regra)) {
      return in_array($regra, $permissoesUsuario);
    }

    // Se a regra for um array (condições complexas, como Nível OU Papel)
    if (is_array($regra)) {
      // Verifica se o nível de acesso é suficiente
      if (isset($regra['nivel_acesso']) && $nivelAcessoUsuario >= $regra['nivel_acesso']) {
        return true;
      }
      // Verifica se o usuário tem o papel/permissão necessária
      if (isset($regra['nivel_permissao']) && in_array($regra['nivel_permissao'], $permissoesUsuario)) {
        return true;
      }
    }

    // Se nenhuma regra foi satisfeita, nega o acesso.
    return false;
  }

  // Array de todos os possíveis itens do menu
  $menuItens = [
    ['page' => 'workshop_tus', 'display' => 'Workshop TUS'],
    ['page' => 'papo_four', 'display' => 'Papo Família Mod 04'],
    ['page' => 'workshop', 'display' => 'Workshop'],
    ['page' => 'papo', 'display' => 'Papo Família Mod 01'],
    ['page' => 'papo_two', 'display' => 'Papo Família Mod 02'],
    ['page' => 'papo_three', 'display' => 'Papo Família Mod 03'],
    ['page' => 'colonia_te', 'display' => 'Colonia Terapeutica'],
    ['page' => 'inscricao', 'display' => 'Imersão Wilson'],
    ['page' => 'te_inscricao', 'display' => 'TE Experience']

  ];

  // Array de permissões (corrigido e organizado)
  $permissoesTabelas = [
    'te_inscricao' => ['nivel_acesso' => 1, 'nivel_permissao' => 'palestrante_te'],
    'inscricao' => 4,
    'papo' => 3,
    'papo_two' => 3,
    'papo_three' => 3,
    'papo_four' => 3,
    'workshop' => 5,
    'workshop_tus' => 5,
    'colonia_te' => 3
  ];

  ?>

  <div class="container">
    <nav>
      <ul id="menuFiltros" class="filters-list">

        <li>
          <a href="#" class="logo gradient-link nav-item">
            <img src="./assets/img/sem-foto.png" width="32" height="32"><span class="titleNav"><?php echo firstName($usuario['nome']); ?></span>
          </a>
        </li>

        <hr>

        <li>
          <a class="nav-item gradient-link filter-link" href="#" data-filter="todos" data-subtitle="Todos Inscritos">
            <i class="fas fa-solid fa-store"></i><span class="titleNav">Todos Inscritos</span>
          </a>
        </li>
        <li>
          <a class="nav-item gradient-link filter-link" href="#" data-filter="pagos" data-subtitle="Confirmados Pagos">
            <i class="fas fa-check"></i><span class="titleNav">Confirmados Pagos</span> </a>
        </li>
        <li>
          <a class="nav-item gradient-link filter-link" href="#" data-filter="isentos" data-subtitle="Confirmados Isentos">
            <i class="fas fa-check"></i> <span class="titleNav">Confirmados Isentos</span> </a>
        </li>
        <li>
          <a class="nav-item gradient-link filter-link" href="#" data-filter="pendentes" data-subtitle="Pendentes">
            <i class="fas fa-tasks"></i> <span class="titleNav">Pendentes</span>
          </a>
        </li>
        <li>
          <a class="nav-item gradient-link filter-link" href="#" data-filter="desistente/cancelados" data-subtitle="Desistente&nbsp;/ Cancelados">
            <i class="fas fa-times"></i> <span class="titleNav">Desistente&nbsp;/ Cancelados</span> </a>
        </li>
        <li>
          <a class="nav-item gradient-link filter-link" href="#" data-filter="cupom" data-subtitle="Cupom">
            <i class="fas fa-newspaper"></i><span class="titleNav">Cupom</span> </a>
        </li>
        <li>
          <a class="nav-item gradient-link filter-link" href="#" data-filter="NomeCracha" data-subtitle="Nome Cracha">
            <i class="fa fa-address-book"></i><span class="titleNav">Nome Cracha</span> </a>
        </li>
        <li>
          <a class="nav-item gradient-link filter-link" href="#" data-filter="Check-in-R" data-subtitle="Check-in Realizado">
          <i class="fa fa-solid fa-square-check"></i><span class="titleNav">Check-in Realizado</span> </a>
        </li>
        <li>
          <a class="nav-item gradient-link filter-link" href="#" data-filter="Check-in-P" data-subtitle="Check-in Pendentes">
          <i class="fa fa-solid fa-question"></i><span class="titleNav">Check-in Pendentes</span> </a>
        </li>
        <!-- <li>
          <a class="nav-item gradient-link filter-link" href="#" data-filter="Ordem pagamento" data-subtitle="Ordem de pagamento">
          <i class="fa fa-solid fa-square-check"></i><span class="titleNav">Ordem de pagamento</span> </a>
        </li>
        <li>
          <a class="nav-item gradient-link filter-link" href="#" data-filter="Ordem Isento" data-subtitle="Ordem cadastro Isento">
          <i class="fa fa-solid fa-square-check"></i><span class="titleNav">Ordem Cadastro Isento</span> </a>
        </li> -->

        <li>
          <a class="nav-item logout gradient-link filter-link" href="#" data-filter="logout">
            <i class="fas fa-sign-out-alt"></i>
            <span class="titleNav">Logout</span></a>
        </li>

      </ul>

    </nav>
    <section class="main">

      <div class="main-top">
        <div>
          <h1><span id="tableSelect"></span></h1><br>
          <h4><span id="subpageTitle"></span></h4>
        </div>

        <i class="fa fa-solid fa-bars" id="menu-icon">
          <div class="dropdown-menu" id="myDropdown">
            <ul>
              <?php foreach ($menuItens as $item) : ?>
                <?php if (podeAcessar($item['page'], $usuario, $permissoesTabelas)) : ?>
                  <li>
                    <a href="#" class="menu-link" data-page="<?= htmlspecialchars($item['page']) ?>" data-display="<?= htmlspecialchars($item['display']) ?>">
                      <?= htmlspecialchars($item['display']) ?>
                    </a>
                  </li>
                <?php endif; ?>
              <?php endforeach; ?>
            </ul>
          </div>

        </i>
      </div>

      <div id="user" class="users">

        <div class="card">
          <li><a class="filter-link a-button" href="#" data-filter="todos" data-subtitle="Todos Inscritos">Todos Inscritos</a></li>
          <div class='card_content'>
            <p class='card_text'><span class='inscritos'></span></p>
          </div>
        </div>

        <div class="card">
          <li><a class="filter-link a-button" href="#" data-filter="pagos" data-subtitle="Confirmados Pagos">Confirmados Pagos</a></li>
          <div class='card_content'>
            <p class='card_text'> <span class="confirmados-pago"></span></p>
          </div>
        </div>

        <div class="card">
          <li><a class="filter-link a-button" href="#" data-filter="isentos" data-subtitle="Confirmados isento">Confirmados Isentos</a></li>
          <div class='card_content'>
            <p class='card_text'> <span class='confirmados-isento'></span></p>
          </div>
        </div>

        <div class="card">
          <li><a class="filter-link a-button" href="#" data-filter="pendentes" data-subtitle="Pendentes">Pendentes</a></li>
          <div class='card_content'>
            <p class='card_text'><span class='pendentes'></span></p>
          </div>
        </div>

        <div class="card">
          <li><a class="filter-link a-button" href="#" data-filter="desistente/cancelados" data-subtitle="Desistente&nbsp;/ Cancelados">Desistente&nbsp;/ Cancelados</a></li>
          <div class='card_content'>
            <p class='card_text'> <span class='cancelados'></span></p>
          </div>
        </div>

      </div>


      <section id="dynamicDataContainer" class="attendance">
        <!-- O conteúdo dinâmico será carregado aqui -->
      </section>

    </section>
  </div>

  <?php
  // Filtra os itens do menu para obter apenas as páginas que o usuário pode acessar.
  $paginasPermitidas = [];
  foreach ($menuItens as $item) {
    if (podeAcessar($item['page'], $usuario, $permissoesTabelas)) {
      $paginasPermitidas[] = [
        'page' => $item['page'],
        'display' => $item['display']
      ];
    }
  }

  // Define a página padrão como a primeira da lista de permitidas.
  $paginaPadrao = !empty($paginasPermitidas) ? $paginasPermitidas[0] : null;
  ?>

  <!-- Passando os dados de permissão do PHP para o JavaScript -->
  <script>
    const userPermissions = {
      allowedPages: <?= json_encode($paginasPermitidas, JSON_HEX_TAG | JSON_HEX_APOS); ?>,
      defaultPage: <?= json_encode($paginaPadrao, JSON_HEX_TAG | JSON_HEX_APOS); ?>
    };
  </script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="./js/dash_fetchOnev5.js"></script>
  <script src="./js/getCertificado.js"></script>
  <script>
    function copiarTexto(texto, botao) {
      // Se o botão já tem a classe 'copiado', não faz nada para evitar re-copiar
      if (botao.classList.contains('copiado')) {
        // Você pode reativar a cópia se quiser, removendo este if
        return;
      }

      navigator.clipboard.writeText(texto).then(function() {
        // --- MUDANÇA PRINCIPAL ---
        // 1. Adiciona a classe para mudar a cor permanentemente
        botao.classList.add('copiado');

        // 2. Altera o texto do botão para dar feedback visual temporário
        botao.innerText = 'Copiado!';

        // 3. Desabilita o botão temporariamente para evitar cliques múltiplos
        botao.disabled = true;

        // 4. Após 2 segundos, reverte APENAS o texto e o estado 'disabled'
        setTimeout(function() {
          botao.innerText = 'Copiar'; // Volta o texto para 'Copiar'
          botao.disabled = false; // Reabilita o botão
          // A classe 'copiado' NÃO é removida, então a cor permanece.
        }, 5000);

      }).catch(function(err) {
        console.error('Erro ao copiar texto: ', err);
        alert('Não foi possível copiar o telefone.');
      });
    }
  </script>
</body>

</html>