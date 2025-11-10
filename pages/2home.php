<?php $title = 'Imersão'; ?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title ? $title : $titleSite; ?></title>
    <link rel="stylesheet" href="./css/style_global.css" />
    <link rel="stylesheet" href="./css/homecs.css" />
    <link rel="stylesheet" href="./css/cscarrossel_papo.css" />
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

    <link rel="icon" href="./assets/img/favicon.png" sizes="32x32">


</head>

<!-- scroll-behavior -->

<body class="container-fluid" id="inicio">

    <section class="section-content-container">
        <div class="section-content">
            <img src="./assets/img-landing/page1.png" alt="Imagem 1">
        </div>
        <div id="pagament1">
            <a href="https://assistaconecta.com.br/lotes"><button class="botao-sombra1">Inscreva-se agora</button></a>
        </div>
    </section>

    <section class="section-content-container">
        <div class="section-content">
            <img src="./assets/img-landing/page2.png" alt="Imagem 2">
        </div>
        <div id="pagament2">
            <a href="https://assistaconecta.com.br/lotes"><button class="botao-sombra1">Inscreva-se agora</button></a>
        </div>
    </section>



    <section class="section-content-container">
        <div class="section-content">
            <img src="./assets/img-landing/page3.png" alt="Imagem 3">
        </div>
        <div id="pagament3">
            <a href="https://assistaconecta.com.br/lotes"><button class="botao-sombra1">Inscreva-se agora</button></a>
        </div>
    </section>

    <div class="carousel-container">
        <div class="carousel">
            <img src="./assets/img-landing/page4.png" alt="Imagem 4">
            <img src="./assets/img-landing/page5.png" alt="Imagem 5">
        </div>
        <button class="carousel-controlpapo carousel-controlpapo-prev" onclick="previousSlide()">❮</button>
        <button class="carousel-controlpapo carousel-controlpapo-next" onclick="nextSlide()">❯</button>
        <div class="carousel-nav">
            <button data-slide="0" class="active"></button>
            <button data-slide="1"></button>
        </div>
    </div>

    <section class="section-content-container">
        <div class="section-content">
            <img src="./assets/img-landing/page6.png" alt="Imagem 6">
        </div>
        <div id="pagament4">
            <a href="https://assistaconecta.com.br/lotes"><button class="botao-sombra1">Inscreva-se agora</button></a>
        </div>
    </section>
    <section class="section-content-container">
        <div class="section-content">
            <img src="./assets/img-landing/page7.png" alt="Imagem 7">
        </div>
        <div id="pagament5">
            <a href="https://assistaconecta.com.br/lotes"><button class="botao-sombra1">Inscreva-se agora</button></a>
        </div>
    </section>


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

    <script type="text/javascript" src="./js/vanilla.js"></script>
    <script type="text/javascript" src="./js/mask.js"></script>
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