<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Colonia terapeutica</title>
    <link rel="stylesheet" href="./css/style_global.css" />
    <!-- <link rel="stylesheet" href="./css/home_style.css" /> -->
    <link rel="stylesheet" href="./css/cscarrossel_papo.css" />
    <!-- <link rel="stylesheet" href="./css/cspapocs.css" /> -->
    <link rel="stylesheet" href="./css/colonia_g.css" />
    <link rel="stylesheet" href="./css/colonia_exp.css" />
    <link rel="stylesheet" href="./css/colonia_formNew.css" />
    <!-- <link rel="stylesheet" href="./css/colonia_exper.css" /> -->
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
    <link rel="icon" href="./assets/colonia/favicon.png" sizes="32x32">

</head>

<!-- scroll-behavior -->

<body class="container-fluid" id="inicio">

    <div class="carousel-container">

        <div class="carouselpage">
            <img src="./assets/colonia/colonia01.jpg" alt="Imagem 1">
        </div>
        <div class="section-1-content">
            <a href="#papo5"><button class="botao-sombra"> Inscreva-se agora</button></a>
        </div>
    </div>

    <div class="carousel-container">
        <div class="carousel">
            <img src="./assets/colonia/colonia02.jpg" alt="Imagem 1">
            <img src="./assets/colonia/colonia03.jpg" alt="Imagem 2">
        </div>
        <button class="carousel-controlpapo carousel-controlpapo-prev" onclick="previousSlide()">❮</button>
        <button class="carousel-controlpapo carousel-controlpapo-next" onclick="nextSlide()">❯</button>
        <div class="carousel-nav">
            <button data-slide="1" class="active"></button>
            <button data-slide="2"></button>
        </div>

        <div class="section-2-content">
            <a href="#papo5"><button class="botao-sombra"> Inscreva-se agora</button></a>
        </div>
    </div>

    <div class="carousel-container">

        <div class="carouselpage">
            <img src="./assets/colonia/colonia04.jpg" alt="Imagem 2">
        </div>
        <div class="section-3-content">
            <a href="#papo5"><button class="botao-sombra"> Inscreva-se agora</button></a>
        </div>
        <div class="section-4-content">
            <a href="https://web.whatsapp.com/send?phone=5581995343141" target='_blank'><button class="botao-zap"> (81) 99534 3141</button></a>
        </div>

    </div>


    <div id="papo5" class="carousel-container">

        <div id="papo5Title"></div>

        <!-- <div class="carouselpage">
            <img src="./assets/papo/papo5.jpg" alt="Imagem 5">
        </div> -->

        <div id="zerocontorno" class="contorno">

            <form id="frmInsc_lote" method="post" onsubmit="return false;">

                <div id="step-0" class="step active">
                    <div class="vendah">
                        <h2>Inscrições</h2>
                        <span class="loteper"><strong>Até <strong> 10/07</strong></span>
                        <span>selecione os dias de atividades</span>
                    </div>

                    <div class="custom-radio">

                        <input type="radio" class="mod_two" id="loteone_one" name="loteone_radio" value="11/07">
                        <label for="loteone_one"><i class="fa fa-check" aria-hidden="true"></i>Atividade no dia - 11/07
                            <span class="xvista">R$ 100,00</span>
                        </label>

                        <input type="radio" class="mod_two" id="loteone_two" name="loteone_radio" value="18/07">
                        <label for="loteone_two"><i class="fa fa-check" aria-hidden="true"></i>Atividade no dia - 18/07
                            <span class="xvista">R$ 100,00</span>
                        </label>

                        <input type="radio" class="mod_two" id="loteone_three" name="loteone_radio" value="Dois dias">
                        <label for="loteone_three"><i class="fa fa-check" aria-hidden="true"></i>Atividades nos dias - 11/07 e 18/07
                            <span class="xvista">R$ 180,00</span>
                        </label>

                    </div>

                    <hr class="divider">
                    <button type="button" id="btn-to-email" class="tebtn btn btn-success btn-modalidade-one">
                        Continuar
                        <i class="fas fa-chevron-right icon-right"></i>
                    </button>
                </div>

                <div id="step-1" class="step">
                    <div class="step-header">
                        <div class="step-title-container">
                            <button type="button" data-action="back" data-target="step-0" class="icon-button">
                                <i class="fas fa-chevron-left mr-1"></i>
                            </button>
                            <h2 class="step-title">Verificação de E-mail</h2>
                        </div>
                        <p class="step-subtitle">Vamos verificar se você já possui uma conta.</p>
                    </div>

                    <div>
                        <label for="email" class="form-label">Seu E-mail:</label>
                        <input type="email" id="email" name="email" class="form-input" placeholder="seu.email@exemplo.com" required>
                    </div>
                    <div id="loader-email" class="loader"></div>
                    <div id="message-email" class="form-message"></div>
                    <hr class="divider">
                    <div class="form-actions">
                        <button type="button" id="btn-check-email" class="tebtn">Verificar E-mail <i class="fas fa-chevron-right icon-right"></i></button>
                    </div>
                </div>

                <div id="step-2" class="step">
                    <div class="step-header">
                        <div class="step-title-container">
                            <button type="button" data-action="back" data-target="step-1" class="icon-button">
                                <i class=" fas fa-chevron-left mr-1"></i>
                            </button>
                            <h2 class="step-title">Verificação de CPF</h2>
                        </div>
                        <p class="step-subtitle">Agora, informe seu CPF do responsável.</p>
                    </div>

                    <div>
                        <label for="cpf" class="form-label">Seu CPF:</label>
                        <input type="text" id="cpf" name="cpf" class="form-input" placeholder="000.000.000-00" required>
                    </div>
                    <div id="loader-cpf" class="loader"></div>
                    <div id="message-cpf" class="form-message"></div>
                    <hr class="divider">
                    <div class="form-actions">
                        <button type="button" id="btn-check-cpf" class="tebtn">Verificar CPF <i class="fas fa-chevron-right icon-right"></i></button>
                    </div>
                </div>

                <div id="step-3" class="step">
                    <div class="step-header">
                        <div class="step-title-container">
                            <button type="button" data-action="back" data-target="step-2" class="icon-button">
                                <i class=" fas fa-chevron-left mr-1"></i>
                            </button>
                            <h2 class="frmulario" style="font-size: 22px; text-align: left; margin-bottom: 0;">Dados do participante</h2>
                        </div>
                        <p class="step-subtitle" style="margin-bottom: 1rem">Agora, informe o restante dos dados.</p>
                    </div>

                    <div class="form-group">
                        <label for="nome" class="frmulario">NOME DA CRIANÇA: <span style="color: red;">*</span></label>
                        <input type="text" id="nome" name="nome" placeholder="Nome" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="responsavel" class="frmulario">NOME DO RESPONSÁVEL: <span style="color: red;">*</span></label>
                        <input type="text" id="responsavel" name="responsavel" placeholder="Responsavel" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label for="final_cpf" class="frmulario">CPF DO RESPONSÁVEL: <span style="color: red;">*</span></label>
                        <input type="text" id="final_cpf" name="final_cpf" placeholder="CPF" class="form-input form-input-readonly" readonly>
                    </div>

                    <div class="form-group">
                        <label for="final_email" class="frmulario">E-MAIL: <span style="color: red;">*</span></label>
                        <input type="email" id="final_email" name="final_email" placeholder="E-mail" class="form-input form-input-readonly" readonly>
                    </div>

                    <div class="form-group">
                        <label for="telefone" class="frmulario">TELEFONE: <span style="color: red;">*</span></label>
                        <input type="tel" id="telefone" name="telefone" placeholder="Telefone" class="form-input" required>
                    </div>

                    <!-- <div class="form-group">
                        <label for="cracha" class="frmulario">NOME PARA USO NO CRACHÁ: <span style="color: red;">*</span></label>
                        <input type="text" id="cracha" name="cracha" placeholder="Nome Crachá" class="form-input" required>
                    </div> -->

                    <div id="docUp">
                        <label class="form-label mtopBut10"><strong style="color: #af2846;">Selecione um comprovante</strong></label>
                        <div id="docUpload">
                            <div class="file-upload">
                                <input type="file" id="imagefile" name="docfile" class="image" accept=".jpg, .jpeg, .png, .pdf">
                                <label for="imagefile" class="file-upload-label">
                                    <i class="fas fa-upload"></i> Escolher Arquivo
                                </label>
                                <span id="file-name" class="file-name-display text-secondary">Nenhum arquivo selecionado</span>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="btn-to-payment" class="tebtn" style="margin-top: 10px;">
                        CONTINUAR <i class="fas fa-chevron-right"></i>
                    </button>
                    <div class="selecao" style="margin-top: 20px; text-align: center;">
                        Atividade selecionada: <strong id="modalidade-display"></strong>
                    </div>
                    <hr class="divider">
                </div>

                <div id="step-4" class="step">
                    <div class="confirmation-container">
                        <h2 id="step-final" class="confirmation-title">Pré-inscrição confirmada!*</h2>
                        <span id="step-confirm" class="step-subtitle" style="margin-bottom: 1rem; font-size: 18px;"></span>
                        <div class="summary-box">
                            <h3 class="summary-title">Resumo da compra</h3>
                            <div class="summary-item">
                                <p class="summary-label">Nome do participante:</p>
                                <p id="summary-name" class="summary-resum"></p>
                            </div>
                            <div class="summary-item">
                                <p class="summary-label">Modalidade da compra para:</p>
                                <p id="summary-modality" class="summary-resum"></p>
                            </div>
                            <div>
                                <p id="sumary-p-label" class="summary-label">Valor:</p>
                                <p id="summary-value" class="summary-resum"></p>
                            </div>
                        </div>
                        <div id="pague">
                            <p class="payment-prompt">Pague clicando no botão abaixo:</p>

                            <div id="sumary-pagamento" class="payment-button"></div>

                            <p class="disclaimer-text">*Sua inscrição será confirmada após a aprovação do pagamento.</p>
                        </div>
                        <div id="precce"></div>
                    </div>
                    <hr class="divider">
                    <!-- <div class="restart-container">
                            <button type="button" id="btn-restart" class="restart-button">
                                <i class="fas fa-sync-alt mr-1"></i> Voltar para o início!
                            </button>
                        </div> -->
                </div>
            </form>

        </div>
    </div>


    <footer>

        <div id="logo-foot" class="logo-foot-img"></div>
        <div class="foot-end">
            <div>
                <p><span>Dúvidas? Fale com nosso time: &nbsp;</span></p>
            </div>
            <div>
                <a href="https://wa.me/5581996419472" target='_blank'> (81) 99641 9472 <i class="fab fa-whatsapp"></i></p>
            </div>
        </div>

    </footer>

    <?php
    include './includes/scripts.php';
    ?>

    <script src="https://unpkg.com/vanilla-masker@1.1.1/build/vanilla-masker.min.js"></script>

    <!-- <script type="text/javascript" src="./js/vanilla.js"></script> -->
    <script type="text/javascript" src="./js/mask.js"></script>
    <script type="text/javascript" src="./js/colonia-formOne.js"></script>
    <!-- <script type="text/javascript" src="./js/sqls_papothree.js"></script> -->
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