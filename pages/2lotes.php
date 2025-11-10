<?php
// header("Location: cart");
// die();
?>

<?php $title = 'Lotes'; ?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title ? $title : 'Vendas'; ?></title>
    <!-- Text font -->
    <link rel="stylesheet" href="./css/style_global.css" />
    <link rel="stylesheet" href="./css/home_style.css" />
    <link rel="stylesheet" href="./css/home_media.css" />
    <link rel="stylesheet" href="./css/cscartcsthree.css" />
    <link rel="stylesheet" href="./css/style_card.css" />
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://assets.pagseguro.com.br/checkout-sdk-js/rc/dist/browser/pagseguro.min.js"></script>
    <link rel="icon" href="./assets/img/favicon.png" sizes="32x32">

</head>

<!-- scroll-behavior -->

<body id="inicio">

    <?php
    // include "includes/navbar.php"
    ?>

    <div id="entrada"></div>
    <div id="entrada-conecta"></div>


    <header class="event-cart">

        <div class="divflexTop">

            <div id="principal">
                <p id="event-two" class="about-event-two">IMERSÃO</p>
                <p class="about-event"> REGULAÇÃO EMOCIONAL EM PSICOTERAPIA </p>
            </div>

        </div>


        <div class="divflexCart">

            <div id="zerocontorno" class="contorno">
                <?php
                include './forms/lote_mod_two.php';
                ?>
            </div>
            <div id="onecontorno" class="contorno">
                <?php
                include './forms/lote_mod_four.php';
                ?>
            </div>
            <div id="twocontorno" class="contorno">
                <?php
                include './forms/lote_mod_three.php';
                ?>
            </div>

        </div>

    </header>


    <div id="reta01">
        <p>24 de maio</p>
    </div>


    <section id="pagamento" style="height: 100vh;">

        <div class="container_for">

            <form id="frmInsc_lote" method="post">

            </form>

            <form id="formGrupo" method="post">

            </form>

        </div>

        <div class="container_res">

            <div id="resumo_compra">
                <div class="wrapper">
                    <div id="cardresForm">

                    </div>

                </div>
            </div>

            <div id="resumo_pagamento">

                <div class="wrapper" id="app">
                    <div class="card-form">

                        <form method="post" name="formCard" id="formCard">

                        </form>
                        <!-- <div id="status"></div> -->
                    </div>
                </div>

            </div>

        </div>

    </section>



    <?php
    include './includes/footer_two.php';
    ?>

    <?php
    include './includes/scripts.php';
    ?>

    <!-- <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script> -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js'></script>
    <script src='https://unpkg.com/vue-the-mask@0.11.1/dist/vue-the-mask.js'></script>

    <script src='https://cdn.rawgit.com/lagden/vanilla-masker/lagden/build/vanilla-masker.min.js'></script>
    <script type="text/javascript" src="./js/cep.js"></script>
    <script type="text/javascript" src="./js/vanilla.js"></script>
    <script type="text/javascript" src="./js/mask.js"></script>
    <!-- <script type="text/javascript" src="./js/form_lotesf.js"></script> -->
    <script type="text/javascript" src="./js/sqls_three.js"></script>
    <script type="text/javascript" src="./js/sqls_grupo.js"></script>

</body>

</html>