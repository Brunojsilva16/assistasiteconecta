<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Exemplo de header e sidebar responsivos</title>

    <style>
        body {
            margin: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            height: 50px;
            padding: 10px;
        }

        ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        li {
            display: inline-block;
            margin-right: 10px;
        }

        a {
            color: #fff;
            text-decoration: none;
        }

        .sidebar {
            display: block;
            top: 0px;
            left: 0;
            translate: 0px 0px;
            min-height: 100vh;
            min-width: 200px;
            width: 200px;
            position: fixed;
            background-color: #333;
            translate: -100% 0px;
            transition: 0.5s ease;
        }

        .sidebar nav ul {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            margin: 20px 0px;
        }

        .sidebar nav ul li {
            margin: 20px 0px;
        }

        .sidebar.open {
            translate: 0px 0px;
        }

        main {
            margin: 10px;
            padding-top: 50px;
        }

        @media (max-width: 768px) {
            header {
                display: none;
            }

            /* Estilos para o botão de menu */
            .menu-button {
                display: block;
                position: fixed;
                top: 10px;
                right: 10px;
                width: 30px;
                height: 30px;
                background-color: #333;
                border: none;
                cursor: pointer;
            }

            .menu-button span {
                display: block;
                width: 20px;
                height: 3px;
                background-color: #fff;
                margin: 5px auto;
            }
        }

        /* Estilos para desktop */
        @media (min-width: 769px) {
            header {
                display: block;
            }

            .menu-button {
                display: none;
            }
        }
    </style>


</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Sobre nós</a></li>
                <li><a href="#">Contato</a></li>
            </ul>
        </nav>
    </header>
    <aside class="sidebar">
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Sobre nós</a></li>
                <li><a href="#">Contato</a></li>
            </ul>
        </nav>
    </aside>
    <button class="menu-button" aria-expanded="false" aria-controls="sidebar-menu">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <main>
        <section>
            <h2>Sobre nós</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vitae eros justo. Nulla facilisi. Fusce a lacinia
                mi. Fusce tempor, nulla eu aliquam convallis, velit elit commodo elit, sit amet finibus quam mauris a risus.
                Aenean ultrices eleifend tincidunt. Praesent non est nibh. Fusce euismod nulla eget efficitur auctor. In a eros
                vitae ipsum suscipit tempor.</p>
        </section>
        <section>
            <h2>Contato</h2>
            <p>Entre em contato conosco:</p>
            <ul>
                <li>Telefone: (11) 1234-5678</li>
                <li>Email: contato@meusite.com</li>
            </ul>
        </section>
    </main>
</body>
<script>
    
    const menuButton = document.querySelector('.menu-button');
    const sidebar = document.querySelector('.sidebar');

    menuButton.addEventListener('click', () => {
        console.log('toggle')
        const expanded = menuButton.getAttribute('aria-expanded') === 'true' || false;
        menuButton.setAttribute('aria-expanded', !expanded);
        sidebar.classList.toggle('open');
    });
</script>

</html>