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
    <link rel="stylesheet" href="./css/te-ciab.css" />
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

<body id="inicio">

    <section id="lotes">
        <div class="divflexCart">

            <div id="teforms" class="contorno">
                <form id="frmInsc_lote" method="post">
                    <div>
                        <p style="font-size: 20px; font-weight:700">Dados do participante</p>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-lg-12 ">
                            <label id="labelNome" class="labelObrigatorio"><strong class="frmulario">NOME:<span class="obrig"> *</span> <span class="inputNomepac-info infoAlerta"></span></strong></label>
                            <input type="text" id="inputNome" class="form-control input-required" maxlength="100" name="nome" placeholder="Nome">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-lg-12 ">
                            <label id="labelEmail"><strong class="frmulario">E-MAIL:<span class="obrig"> *</span></strong></label>
                            <input type="email" id="inputEmail" class="form-control" maxlength="100" name="email" placeholder="E-mail" aria-label="mail">
                        </div>
                        <div class="col-md-12 col-sm-12 col-lg-12 ">
                            <label id="labelTelefone"><strong class="frmulario">TELEFONE:<span class="obrig"> *</span></strong></label>
                            <input type="text" id="inputTelefone" class="form-control" minlength="15" maxlength="15" name="whatsapp" placeholder="Telefone" aria-label="Telefone">
                        </div>
                    </div>

                    <div class="row">
                        <div style="margin: 10px 0px;" class="col-12 align-self-start upp doww">
                            <div class="row align-self-start">
                                <div class="col-8 upp">
                                    <input id="value-mod-select" name="mod_select" type="hidden">
                                    <input id="value-lote-select" name="lote_select" type="hidden">
                                    <button id="dadoslote_one" type="submit" class="tebtn btn btn-success">Cadastrar <i class="fas fa-solid fa-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carregando" style="color:green"></div>
                    <div class="resultadoLoading" style="color: red;"></div>

                </form>

            </div>

        </div>
    </section>

    <?php
    include './includes/te-footer.php';
    ?>

    <?php
    include './includes/scripts.php';
    ?>

    <!-- <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script> -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js'></script>
    <script src='https://unpkg.com/vue-the-mask@0.11.1/dist/vue-the-mask.js'></script>

    <script src='https://cdn.rawgit.com/lagden/vanilla-masker/lagden/build/vanilla-masker.min.js'></script>
    <script type="text/javascript" src="./js/mask.js"></script>

    <script type="text/javascript" src="./js/connorte.js"></script>
    <script>
        function inputHandler(masks, max, event) {
            var c = event.target;
            var v = c.value.replace(/\D/g, '');
            var m = c.value.length > max ? 1 : 0;
            VMasker(c).unMask();
            VMasker(c).maskPattern(masks[m]);
            c.value = VMasker.toPattern(v, masks[m]);
        }

        function callMaskRes() {
            var telMask = ['(99) 99999-9999'];
            var tel = document.querySelector('input[name="whatsapp"]');
            VMasker(tel).maskPattern(telMask[0]);
            tel.addEventListener('input', inputHandler.bind(undefined, telMask, 16), false);
        }

        callMaskRes();
    </script>

</body>

</html>