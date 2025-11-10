<h1>Painel</h1>
<ul>
    <li>
        <a href="painel_geral" class="panel_includs <?= $title == 'Painel Geral' ? "active" : ''; ?>">
            <i class="fas fa-solid fa-store fa-lg"></i>
            Geral
        </a>
    </li>
    <li>
        <a href="painel_cupons" class="panel_includs <?= $title == 'Painel Cupons' ? "active" : ''; ?>">
            <i class="fas fa-newspaper fa-lg"></i>
            Cupons
        </a>
    </li>
    <li>
        <a href="painel_equipe" class="panel_includs <?= $title == 'Painel Equipe' ? "active" : ''; ?>">
            <i class="fas fa-newspaper fa-lg"></i>
            Equipe
        </a>
    </li>
    <li>
        <a href="painel_confirmados" class="panel_includs <?= $title == 'Painel Confirmados' ? "active" : ''; ?>">
            <i class="fas fa-check"></i>
            Confirmados
        </a>
    </li>
    <li>
        <a href="painel_pendentes" class="panel_includs <?= $title == 'Painel Pendentes' ? "active" : ''; ?>">
            <i class="fas fa-tasks"></i>
            Pendentes
        </a>
    </li>
</ul>