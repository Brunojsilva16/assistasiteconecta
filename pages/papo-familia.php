<?php $title = 'Papo Família'; ?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title ? $title : $titleSite; ?></title>
    <link rel="stylesheet" href="./css/style_global.css" />
    <!-- <link rel="stylesheet" href="./css/home_style.css" /> -->
    <link rel="stylesheet" href="./css/cscarrossel_papo.css" />
    <!-- <link rel="stylesheet" href="./css/cspapocs.css" /> -->
    <link rel="stylesheet" href="./css/papocsstwo.css" />
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
    <link rel="icon" href="./assets/papo/favicon.png" sizes="32x32">

</head>

<!-- scroll-behavior -->

<body class="container-fluid" id="inicio">

    <?php
    // include "includes/navbar.php"
    ?>

    <div class="carousel-container">

        <div class="carouselpage">
            <img src="./assets/papo/sect_one_center.png" alt="Imagem 1">
        </div>
        <div class="section-1-content"> <img src="./assets/papo/papo.png">
            <p style="font-weight: 700;">Encontros que te farão refletir sobre a forma de educar os seus filhos.</p>
            <p style="font-weight: 400;">O papo família é pensado por psicólogos especialistas diretamente para as maiores dificuldades da criação dos filhos.</p>

            <a href="#pagamento"><button class="botao-sombra"> Inscreva-se agora</button></a>
        </div>
    </div>


    <div class="carousel-container">

        <div class="carouselpage">
            <img src="./assets/papo/sect_two.png" alt="Imagem 2">
        </div>

    </div>

    <div class="carousel-container">

        <div class="carouselpage">
            <img src="./assets/papo/sect_three.png" alt="Imagem 3">
        </div>

    </div>


    <div class="carousel-container">
        <div class="carousel">
            <img src="./assets/papo/4.png" alt="Imagem 4">
            <img src="./assets/papo/5.png" alt="Imagem 5">
            <img src="./assets/papo/1.png" alt="Imagem 1">
            <img src="./assets/papo/2.png" alt="Imagem 2">
            <img src="./assets/papo/3.png" alt="Imagem 3">
        </div>
        <button class="carousel-controlpapo carousel-controlpapo-prev" onclick="previousSlide()">❮</button>
        <button class="carousel-controlpapo carousel-controlpapo-next" onclick="nextSlide()">❯</button>
        <div class="carousel-nav">
            <button data-slide="4" class="active"></button>
            <button data-slide="5"></button>
            <button data-slide="1"></button>
            <button data-slide="2"></button>
            <button data-slide="3"></button>
        </div>
    </div>


    <div id="papo5" class="carousel-container">

        <div id="papo5Title"></div>

        <!-- <div class="carouselpage">
            <img src="./assets/papo/papo5.png" alt="Imagem 5">
        </div> -->
        <div id="pagamento" class="section-2-content">

            <div id="preco" class="papo5">

                <div id="topleft"></div>
                <div id="logo1"></div>
                <div id="logo2"></div>
                <div id="rodapePapo"></div>


                <div id="individualPreco">

                    <div style="text-align: start;">

                        <h2>Individual</h2>
                        <h1>R$ 150,00</h1>

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
                        <h1>R$ 220,00</h1>

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
        </div>

    </div>


    <footer>

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

    <script src="https://unpkg.com/vanilla-masker@1.1.1/build/vanilla-masker.min.js"></script>

    <!-- <script type="text/javascript" src="./js/vanilla.js"></script> -->
    <script type="text/javascript" src="./js/mask.js"></script>
    <script type="text/javascript" src="./js/sqls_papofour.js"></script>
    <script>
        const carousel = document.querySelector('.carousel');
        const navButtons = document.querySelectorAll('.carousel-nav button');
        const totalSlides = navButtons.length;
        let slideIndex = 0;

        function showSlide(index) {
            if (index < 0) {
                slideIndex = totalSlides - 1;
            } else if (index >= totalSlides) {
                slideIndex = 0;
            } else {
                slideIndex = index;
            }

            const newTransformValue = -slideIndex * 20 + '%';
            carousel.style.transform = `translateX(${newTransformValue})`;

            navButtons.forEach((button, i) => {
                button.classList.toggle('active', i === slideIndex);
            });
        }

        function nextSlide() {
            showSlide(slideIndex + 1);
        }

        function previousSlide() {
            showSlide(slideIndex - 1);
        }

        navButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const slideNumber = parseInt(button.dataset.slide);
                showSlide(slideNumber);
            });
        });
    </script>

</body>

</html>