<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lotes</title>
    <!-- Text font -->
    <link rel="stylesheet" href="./css/style_global.css" />
    <link rel="stylesheet" href="./css/te_newexp.css" />
    <link rel="stylesheet" href="./css/te_newformv2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

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

<body id="inicio">

    <div id="teleft"></div>
    <div id="teright"></div>

    <header class="event-cart">

    </header>

    <section id="lotes">
        <div class="divflexCart">

            <div id="zerocontorno" class="contorno">
            </div>
            <div id="onecontorno" class="contorno">
            </div>
            <div id="twocontorno" class="contorno">
            </div>

        </div>
    </section>

    <?php
    include './includes/te-footer.php';
    ?>

    <?php
    include './includes/scripts.php';
    ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/vanilla-masker@latest/lib/vanilla-masker.min.js'></script>
    <!-- <script src="./js/te-form-two.js"></script> -->

    <script>
        // telotes('./forms/te-lote_mod_zero.php', '#frmInsc_lote');
        function telotes(local, id) {
            // console.log(local);
            $.post(local, function(retorna) {
                $(id).html(retorna);
            });
        }

        telotes('./forms/te-lote_mod_zero.php', '#onecontorno');
        telotes('./forms/te-lote_mod_one.php', '#twocontorno');
        telotes('./forms/te-lote_mod_two.php', '#zerocontorno');

        // document.getElementById("onecontorno").style.display = "none";
        // telotes('./forms/te-lote_mod_three.php', '#twocontorno', 'formGrupo');
    </script>

</body>

</html>