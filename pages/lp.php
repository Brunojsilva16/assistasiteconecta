<?php $title = 'Início'; ?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <title><?php echo $title ? $title : $titleSite; ?></title> -->
    <!-- Text font -->
    <!-- <link rel="stylesheet" href="./css/menu.css" /> -->

    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '955332536414933');
        fbq('track', 'PageView');
    </script>

    <script type="text/javascript">
        (function(c, l, a, r, i, t, y) {
            c[a] = c[a] || function() {
                (c[a].q = c[a].q || []).push(arguments)
            };
            t = l.createElement(r);
            t.async = 1;
            t.src = "https://www.clarity.ms/tag/" + i;
            y = l.getElementsByTagName(r)[0];
            y.parentNode.insertBefore(t, y);
        })(window, document, "clarity", "script", "p9xt591n8y");
    </script>
    <link rel="stylesheet" href="./css/style_global.css" />
    <!-- <link rel="stylesheet" href="./css/home_style.css" /> -->
    <!-- <link rel="stylesheet" href="./css/home_media.css" /> -->
    <link rel="stylesheet" href="./css/lp.css" />
    <link rel="stylesheet" href="./css/cards.css" />
    <link rel="stylesheet" href="./css/evento_lp.css" />
    <link rel="stylesheet" href="./css/quemsou.css" />
    <!-- <link rel="stylesheet" href="/css/menu.css" /> -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />

    <!-- Icons Font -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" />

    <script src="https://kit.fontawesome.com/93bdce3b33.js" crossorigin="anonymous"></script>

    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=955332536414933&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->
    <link rel="icon" href="./assets/img/favicon.png" sizes="32x32">

</head>

<body id="inicio">

    <?php
    // include "includes/navbar.php"
    ?>

    <div id="entrada"></div>
    <div id="entrada-conecta"></div>
    <header class="event-subscription">

        <div class="divflexHeader">

            <div id="facilite01">
                <div id="entrada-one"></div>
            </div>

            <div id="facilite02">

                <div id="subscription-form">
                    <p id="subscription-p" style="font-size: 20px; font-weight: 500;">Entre no grupo VIP para ter acesso a todas as informações do<span style="color: #af2846; font-weight: 700;"> ASSISTA CONECTA</span>
                    </p>
                    <?php
                    include './forms/form_precad.php';
                    ?>
                </div>
                
            </div>

        </div>
    </header>

    <div id="reta01">
        <p>24 de maio</p>
    </div>

    <section id="section_three">

        <div class="flex-container">

            <div id="quem_wilson"></div>

            <div id="perfil_one">
                <h2 class="aprender-title">Conheça <span class="onespan">Wilson Vieira Melo </span></h2>
                <p>Doutor em Psicologia (UFRGS/University of Virginia, US), Mestre em Psicologia Clínica (PUCRS), Treinamento Intensivo em Terapia Comportamental Dialética (Behavioral Tech). Coordenador da Pós-Graduação em Terapia </p>
                <p>Comportamental Dialética do Instituto VilaELO. Ex-Presidente da Federação Brasileira de Terapias Cognitivas - FBTC (Gestões 2019-2021/2021-2023).</p>
                <p>Terapeuta Certificado pela FBTC. Sócio Fundador da Associação de Terapias Cognitivas do Rio Grande do Sul (ATC-RS). Autor de mais de 100 publicações entre livros, capítulos e artigos científicos.</p>

            </div>

        </div>

    </section>


    <section id="section_four">

        <div class="flex-container">

            <div id="quem_paulo"></div>


            <div id="perfil_two">
                <h2 class="aprender-title">Conheça <span class="onespan">Paulo de Tarso Melo</span></h2>
                <p> Paulo de Tarso Melo é Psicólogo, professor e supervisor.
                    Com mais de 16 anos de experiência em psicoterapia, é Mestre e Doutor em Psicologia Clínica e especialista em Terapia Cognitivo-comportamental, com publicações e ampla atuação no cuidado de pessoas com transtornos relacionados ao uso de álcool e outras drogas.</p>

                <p>Possui experiência como coordenador do Programa ATITUDE, consultoria em políticas sobre drogas e atuação em Caps AD.</p>

                <p>Foi 3º vice-presidente da Associação Brasileira de Estudos do Álcool e Outras Drogas (ABEAD) e é membro ativo da instituição, além de ter sido formador federal de prevenção pela FIOCRUZ/SENAD, capacitando profissionais para ações preventivas relacionadas ao consumo de álcool e outras drogas.
                </p>

                <p> Atualmente, é proprietário e CEO da Clínica ASSISTA, onde realiza atendimentos em psicoterapia e supervisiona profissionais, com foco em práticas éticas e baseadas em evidências.
                    Com uma sólida trajetória em Terapia Cognitivo-Comportamental, sua missão é compartilhar conhecimentos que auxiliem profissionais da área da saúde a lidar com os desafios do manejo clínico dos transtornos por uso de substâncias, promovendo saúde e qualidade de vida.</p>


            </div>

        </div>

        <div class="ctb">
            <a href="#inicio">
                <button class="btn btn-success">
                    Entre no grupo VIP⭐
                </button>
            </a>
        </div>

    </section>

    <div id="parceiro" class="cards_all">
        <h1 class="title-parceiro">Parceiros</h1>

        <div class="card_parceiro">
            <div id="parceiro-2">
                <img src="./assets/img/logo_atcpe.png" alt="">
            </div>
        </div>

        <div class="card_parceiro">
            <div id="parceiro-1">
                <img src="./assets/img/psicomanager.png" alt="">
            </div>
        </div>

    </div>


    <?php
    include './includes/footer.php';
    ?>

    <?php
    include './includes/scripts.php';
    ?>

    <script type="text/javascript">
        // function clasButton(valuee) {
        //     valuee.classList.add("deselectButton");
        // }
    </script>
    <script type="text/javascript" src="./js/sqls_insert.js"></script>
    <script type="text/javascript" src="./js/val_telefone.js"></script>
    <!-- <script type="text/javascript" src="./js/form_venda.js"></script> -->

</body>

</html>