<?php

use LoginstatusBase\LoginB;
use LoginstatusMaster\LoginM;

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataLoginB.php';

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataLoginM.php';


if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!empty($_SESSION['nivel_accesso'])) {

    if ($_SESSION['nivel_accesso'] > 1) {
        $login = new LoginM();
    } else {
        $login = new LoginB();
    }

    if ($login->isLoggedIn()) {
        $userData = $login->getUserData(); // Obtém dados do usuário logado
        $image = './assets/img/sem-foto.png';
    } 
    else {
        header('Location: login');
        exit();
    }
} else {
    header('Location: login');
    exit();
}


function firstName($name)
{
    $array = explode(" ", $name);
    return $array[0];
}
?>

<?php $title = 'Painel Geral'; ?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Painel de Controle</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.min.css">


    <link rel="stylesheet" href="./css/cs_dashboard.css">
    <link rel="stylesheet" href="./css/cs_painel.css">
    <!-- <link rel="stylesheet" href="./css/cards.css"> -->
    <link rel="icon" href="./assets/img/favicon.png" sizes="32x32">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js" integrity="sha512-01CJ9/g7e8cUmY0DFTMcUw/ikS799FHiOA0eyHsUWfOetgbx/t6oV4otQ5zXKQyIrQGTHSmRVPIgrgLcZi/WMA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        button.btn-outline:hover::after {
            content: attr(title);
            position: absolute;
            background-color: #333;
            color: white;
            padding: 5px;
            border-radius: 3px;
            /* 			
			left: 50%; */
            transform: translateX(-50%);
            white-space: nowrap;

            display: block;
            left: -4px;
            top: 10px;
            transform: rotate(45deg);
            width: 10px;
            height: 10px;
            background-color: inherit;
        }

        /* button.btn ul li .tooltip {
			display: inline-block;
			position: absolute;
			background-color: #313443;
			padding: 8px 15px;
			border-radius: 3px;
			margin-top: -8px;
			left: 132px;
			opacity: 0;
			visibility: hidden;
			font-size: 13px;
			letter-spacing: 0.5px;
		} */
        button.btn ul li .tooltip:before {
            content: attr(title);
            display: block;
            position: absolute;
            left: -4px;
            top: 10px;
            transform: rotate(45deg);
            width: 10px;
            height: 10px;
            background-color: inherit;
        }

        buttoni:hover::after {
            visibility: visible;
            background-color: #000;
            color: #fff;
            opacity: 1;
        }
    </style>
</head>

<body>

    <div class="wrapper">

        <div class="topbar">
            <h2 id="pageTitle" class="active">Painel Principal</h2>
            <h4 id="subpageTitle"></h4>
        </div>

        <div class="sidebar">
            <div class="profile imagem">

                <div class="dropcircular">
                    <a href="#edit_photo" class="editphoto" onclick="setPhoto('<?php echo $userData['id'] ?>')"
                        data-toggle="modal">
                        <img class="dropcircular" style="width: 64px;
									height: 76px;
									border-radius: 0px;
									margin: 0 auto;" src="<?php echo $image ?>">
                        <span class="textopht">Alterar foto</span>
                    </a>
                </div>
                <div class="dropcircular">
                    <h3 style="color:white; padding: 10px;"><?php echo firstName($userData['nome']); ?></h3>
                </div>

            </div>

            <ul>

                <hr class="hrbord">
                <li data-page="page1" data-title="TE Experience - Vanessa">
                    <a class="subTi" href="#">TE Experience Brasil 2025</a>
                    <ul class="submenu">
                        <li>
                            <a class="subm" href="#" data-subpage="subpage-Te-1" data-subtitle="Inscrição">
                                <i class="fas fa-solid fa-store"></i> Inscrição
                            </a>
                        </li>
                        <li>
                            <a class="subm" href="#" data-subpage="subpage-Te-2" data-subtitle="Pendentes">
                                <i class="fas fa-tasks"></i> Pendentes</a>
                        </li>
                        <li>
                            <a class="subm" href="#" data-subpage="subpage-Te-3" data-subtitle="Confirmados Pagos">
                                <i class="fas fa-check"></i> Confirmados Pagos</a>
                        </li>
                        <li>
                            <a class="subm" href="#" data-subpage="subpage-Te-4" data-subtitle="Confirmados Isentos">
                                <i class="fas fa-check"></i> Confirmados Isentos</a>
                        </li>
                        <li>
                            <a class="subm" href="#" data-subpage="subpage-Te-5" data-subtitle="Cupom">
                                <i class="fas fa-newspaper"></i> Cupom</a>
                        </li>
                        <!-- <li>
							<a class="subm" href="#" data-subpage="subpage-Te-6" data-subtitle="Nome Cracha">
								<i class="fa fa-address-book"></i>
								Nome Cracha</a>
						</li> -->
                    </ul>
                </li>

                <hr class="hrbord">
                <li data-page="logout">
                    <a class="subTi" href="#">logout</a>
                    <ul class="submenu">
                        <li>
                            <a class="subm" href="#" data-subpage="logout">Sair <i class="fa fa-sign-out"></i></a>
                        </li>

                    </ul>
                </li>
                <hr class="hrbord">

            </ul>
        </div>
        <!-- <div class="content"> -->
        <div id="flexCard" class="flexCard container content">
            <!-- <div id="controleSpan">
				<span >
					<i class="fa-solid fa-arrow-left"></i>  Selecione uma opção ao lado
				</span>
			</div> -->


        </div>


        <!-- partial -->
        <script src="./js/te_dashboard.js"></script>
        <?php include './includes/scripts.php'; ?>

        <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script> -->
        <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>



</body>

</html>