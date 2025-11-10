<?php
    header("Location: https://assistaconecta.com.br/quiz_conecta");
    die();
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <link rel="stylesheet" href="./css/quizfcc.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="./assets/img/favicon.png" sizes="32x32">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
</head>

<body>

    <!-- <div class="container mt-12"> -->


    <div class="collapse multi-collapse show" id="multiCollapseExample1">

        <div class="container" id="startquiz">

            <p>Vale salientar que esse quiz é apenas uma forma interativa de refletir sobre seu estilo parental, e não um teste psicológico. Ele serve como um alerta para ajudar você a perceber padrões na sua relação com seus filhos.</p>

            <button class="btn btn-success" id="startbtn" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2">Iniciar o Quiz >></button>

        </div>
    </div>


    <div class="collapse multi-collapse" id="multiCollapseExample2">
        <div id="testquiz" class="quiz-container">
            <div class="question-container">
                <h2 id="question"></h2>
                <ul id="options">
                    <li><button class="option btn btn-outline-dark" data-choice="a">a) <span id="option-a"></span></button></li>
                    <li><button class="option btn btn-outline-dark" data-choice="b">b) <span id="option-b"></span></button></li>
                    <li><button class="option btn btn-outline-dark" data-choice="c">c) <span id="option-c"></span></button></li>
                    <li><button class="option btn btn-outline-dark" data-choice="d">d) <span id="option-d"></span></button></li>
                </ul>
            </div>
            <div class="navigation">
                <button class="btn btn-outline-dark" id="prev">Anterior</button>
                <button class="btn btn-outline-dark" id="next">Próximo</button>
            </div>
        </div>
    </div>

    <div class="container" id="finalquiz">
    </div>

    <div id="dupla">

    </div>



    <div id="topleft"></div>
    <div id="logo1"></div>

    <script src="./js/quizf.js"></script>
    <?php include './includes/scripts.php'; ?>
    <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>


    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script> -->
</body>

</html>