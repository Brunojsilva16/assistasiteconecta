<?php $title = 'Papo Família'; ?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title ? $title : $titleSite; ?></title>
    <link rel="stylesheet" href="./css/style_global.css" />
    <!-- <link rel="stylesheet" href="./css/home_style.css" /> -->
    <link rel="stylesheet" href="./css/papocss.css" />
    <link rel="stylesheet" href="./css/fonts.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>

<!-- scroll-behavior -->

<body class="container-fluid" id="inicio">

    <?php
    // include "includes/navbar.php"
    ?>
  
    <section id="papo5">

        <div id="papo5Title">
            <!-- <p><span class="01">O melhor investimento</span><br>
                <span class="02">para sua família</span>
            </p> -->
        </div>

        <div id="preco" class="papo5">


            <div id="topleft"></div>
            <div id="logo1"></div>
            <div id="logo2"></div>
            <div id="rodapePapo"></div>

            <strong></strong>

            <div id="individualPreco">

                <div style="text-align: start;">

                    <h2>Individual</h2>
                    <h1>R$ 120,00</h1>

                    <ul>
                        <li>Por Módulo</li>
                        <li>Encontro Presencial</li>
                        <li>2h de duração</li>
                        <li>Em até 2x no cartão</li>
                    </ul>
                </div>

                <button id="btnIndividual" class="btn btn-info" id="btnIndividual">Inscreva-se agora</button>

            </div>

            <div id="casalPreco">

                <div style="text-align: start;">

                    <h2>Casal</h2>
                    <h1>R$ 176,00</h1>

                    <ul>
                        <li>Por Módulo</li>
                        <li>Encontro Presencial</li>
                        <li>2h de duração</li>
                        <li>Em até 2x no cartão</li>
                    </ul>
                </div>

                <button id="btnCasal" class="btn btn-info">Inscreva-se agora</button>

            </div>
        </div>

    </section>

    <footer>

<!-- <div class="divflexW">
    <div class="inscreva-form" style="margin-bottom: 20px;">
    <a href="#">
    <input type="submit" class="btn-inscricao btn" value="Inscreva-se aqui" />
    </a>
    </div>

</div> -->

        <div id="logo-foot" class="logo-foot-img"></div>
        <div class="foot-end">
            <div>
                <p><span>Dúvidas? Fale com nosso time: &nbsp;</span></p>
            </div>
            <div>
                <a href="https://wa.me/5581996419472"> (81) 99641 9472 <i class="fab fa-whatsapp"></i></p>
            </div>
        </div>

    </footer>

    <?php
    include './includes/scripts.php';
    ?>

    <script type="text/javascript" src="./js/vanilla.js"></script>
    <script type="text/javascript" src="./js/mask.js"></script>
    <script type="text/javascript" src="./js/sqls_papo_new.js"></script>

</body>

</html>