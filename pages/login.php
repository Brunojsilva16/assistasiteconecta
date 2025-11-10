<?php

use LoginstatusMaster\LoginM;

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataLoginM.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (isset($_SESSION)) {

    $login = new LoginM();

    $urlLocation = 'dashboard';

    if ($login->isLoggedIn()) {
        header('Location: ' . $urlLocation);
        exit();
    }
}


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="./assets/img/favicon.png" sizes="32x32">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <div class="container">
        <div class="Form login-form">

            <div class="displaylogin">
                <img class="login_img" src="./assets/img/conecta_free.png" alt="">
                <h2>Login</h2>
            </div>
            <form id="frm_login">
                <div class="input-box">
                    <i class='bx bxs-user'></i>
                    <input id="login-Email" type="texto" placeholder="Usuário*" name="conecta_email" autocomplete="on">
                    <label id="labelEmail" for="#">Usuário</label>
                </div>
                <div class="input-box">
                    <i class='bx bxs-envelope'></i>
                    <label id="labelSenha" for="#">Senha</label>
                    <input id="login-senha" type="password" placeholder="Senha*" name="conecta_senha" autocomplete="off">
                </div>
                <div class="forgot-section">
                    <span><a href="#">Esquecir a Senha ?</a></span>
                </div>
                <div class="form-group">
                    <label for="nivel_acesso" style="font-size: 12px;">Nível de Acesso:</label>
                    <select class="control" name="conecta_acesso" id="nivel_acesso">
                        <option value="0">Participante</option>
                        <option value="1">Parceiros</option>
                        <option value="2">Colaborador</option>
                        <option value="3">Gerente</option>
                        <option value="3">Administrador</option>
                        <option value="5">Gernciador Sistema</option>
                    </select>
                </div>

                <button type="submit" class="btn">Login</button>
            </form>
            <!-- <p>Or Sign up using</p>
        <div class="social-media">
            <i class='bx bxl-facebook'></i>
            <i class='bx bxl-google'></i>
            <i class='bx bxl-twitter'></i>
        </div> -->
            <p class="RegisteBtn RegiBtn"><a href="#">Cadastre-se agora</a></p>
            <p class="RegisteBtn" style="margin-top: 0;"><a href="home">Voltar ao site</a></p>
        </div>
        <div class="Form Register-form">
            <div class="displaylogin">
                <img class="login_img" src="./assets/img/conecta_free.png" alt="">
                <h2>Cadastrar</h2>
            </div>
            <form action="#">
                <div class="input-box">
                    <i class='bx bxs-user'></i>
                    <label for="#">Usuário</label>
                    <input id="cad-email" type="email" disabled placeholder="Usuário*" autocomplete="on">
                </div>
                <div class="input-box">
                    <i class='bx bxs-envelope'></i>
                    <input id="cad-senha" type="text" disabled placeholder="Senha*" autocomplete="off">
                    <label for="#">Senha</label>
                </div>
                <div class="input-box">
                    <i class='bx bxs-envelope'></i>
                    <input id="cadNew-senha" type="text" disabled placeholder="Confirmar a Senha*" autocomplete="off">
                    <label for="#">Confirmar Senha</label>
                </div>
                <div class="forgot-section">
                    <span><a href="#">Esquecir a Senha ?</a></span>
                </div>
                <button type="submit" disabled class="btn" class="loginBtn">Cadastrar</button>
            </form>
            <!-- <p>Or Sign up using</p>
        <div class="social-media">
            <i class='bx bxl-facebook'></i>
            <i class='bx bxl-google'></i>
            <i class='bx bxl-twitter'></i>
        </div> -->
            <p class="LoginBtn RegisteBtn"><a href="#">Voltar ao login</a></p>
        </div>
    </div>

    <script type="text/javascript" src="./js/loginAll.js"></script>

</body>

</html>