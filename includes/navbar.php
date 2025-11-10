
<nav class="navbar fixed-top navbar-expand-lg navbar-dark">
    <div class="container">
        <!-- <a class="navbar-brand" href="#">Web Zone</a> -->
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="mx-auto"></div>


            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white" href="home" <?php echo $title == 'Início' ? 'id="selected"' : ''; ?>>Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="especialidades" <?php echo $title == 'Especialidades' ? 'id="selected"' : ''; ?>>Especialidades</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="profissionais" <?php echo $title == 'Profissionais' ? 'id="selected"' : ''; ?>>Profissionais</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="galeria" <?php echo $title == 'Galeria' ? 'id="selected"' : ''; ?>>Espaço Físico</a>
                </li>

            </ul>


        </div>
    </div>
</nav>