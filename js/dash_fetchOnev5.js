document.addEventListener('DOMContentLoaded', () => {
    // Seleciona os elementos do DOM
    const dataContainer = document.getElementById('dynamicDataContainer');
    // --- Seletores do DOM ---
    const dropdownMenuLinks = document.querySelectorAll('.menu-link');
    const filterLinks = document.querySelectorAll('.filter-link'); ''
    const linksDoMenu = document.querySelectorAll('#menuFiltros a');

    // Obtém referências para o ícone e o menu dropdown
    const menuIcon = document.getElementById('menu-icon');
    const dropdownMenu = document.getElementById('myDropdown');

    const tableSelectTitle = document.getElementById('tableSelect');
    const subpageTitle = document.getElementById('subpageTitle');

    // ---Inicío do estado da Aplicação ---
    // tableSelect.textContent = 'TE Experience'; // Tabela padrão
    // subpageTitle.textContent = 'Inscrições';
    let urlCaminho = './api_query/fetch_inscritos.php';

    // --- Variáveis de Estado ---
    let activeTable = ''; // Armazena a tabela/página atual (ex: 'te_inscricao')
    let activeTableDisplay = ''; // Armazena o nome de exibição da tabela (ex: 'TE Experience')
    let activeSubpage = 'Todos Inscritos'; // Filtro inicial padrão
    let activeFilter = 'todos'; // Filtro inicial padrão

    const tabelasPermitidas = [
        'inscricao', 'papo', 'papo_two', 'papo_three', 'papo_four', 'te_inscricao', 'workshop', 'workshop_tus', 'codigo', 'colonia_te'
    ];

    /**
     * Verifica se o usuário tem permissão para acessar uma tabela.
     * @param {string} pageName - O nome da página/tabela (ex: 'te_inscricao').
     * @returns {boolean} - true se tiver permissão, false caso contrário.
     */
    function hasPermission(pageName) {
        if (!userPermissions || !userPermissions.allowedPages) {
            console.error("Dados de permissão do usuário não foram encontrados.");
            return false;
        }
        // Procura no array de páginas permitidas se a página solicitada existe.
        return userPermissions.allowedPages.some(page => page.page === pageName);
    }

    async function loadContent(tableName, tableDisplayName, filter) {
        // 1. REGRA DE ACESSO: Verifica a permissão antes de continuar.

        if (!hasPermission(tableName)) {
            // console.warn(`Acesso negado à tabela: "${tableName}".`);

            showLoader(dataContainer, 'Você não tem permissão para visualizar este conteúdo.')
            if (tableSelectTitle) {
                tableSelectTitle.textContent = "Acesso Negado";
            }
            return; // Impede a execução da função.
        }

        // 2. Atualiza o estado global
        activeTable = tableName;
        activeTableDisplay = tableDisplayName;
        activeFilter = filter;

        // 3. Atualiza a interface do usuário (títulos)
        if (tableSelectTitle) {
            tableSelectTitle.textContent = activeTableDisplay;
        }

        if (subpageTitle || filterLinks) {
            subpageTitle.textContent = activeSubpage;
        }

        updateActiveFilterLinkByFilter(filterLinks, activeFilter, 'li');
        fetchcarregaDados(dataContainer, fetchDataWithJQuery, condicoesPage(activeFilter), tableName);
    }

    /**
     * Função de inicialização do dashboard.
     * É chamada uma vez quando a página carrega.
     */
    function initializeDashboard() {
        // Verifica se o objeto de permissões e a página padrão existem
        if (userPermissions && userPermissions.defaultPage) {
            const defaultPage = userPermissions.defaultPage;

            // Define a tabela ativa com base na primeira permissão do usuário
            activeTable = defaultPage.page;

            // Carrega o conteúdo inicial
            loadContent(activeTable, defaultPage.display, activeFilter);
            subpageTitle.textContent = activeSubpage;
        } else {
            // Caso o usuário não tenha permissão para nenhuma tabela
            console.warn("Usuário não tem permissão para nenhuma página ou a página padrão não foi definida.");
            if (tableSelectTitle) {
                tableSelectTitle = "Sem Permissão";
            }
            showLoader(dataContainer, 'Você não tem acesso a nenhum evento no momento.');
            loaderContadores();
            atualizarContadores(); // Zera os contadores
        }
    }

    // --- Funções Auxiliares ---
    function atualizarContadores(dados = {}) {
        // Usamos o operador || para garantir que o valor seja no mínimo 0
        document.querySelector(".inscritos").textContent = (dados.total_count - dados.cancelado_count) || 0;
        document.querySelector(".confirmados-pago").textContent = dados.confirmado_pago || 0;
        document.querySelector(".confirmados-isento").textContent = dados.confirmado_isento || 0;
        document.querySelector(".pendentes").textContent = dados.null_count || 0;
        document.querySelector(".cancelados").textContent = dados.cancelado_count || 0;
    };

    const loaderContadores = () => {
        const contadores = document.querySelectorAll(".inscritos, .confirmados-pago, .confirmados-isento, .pendentes, .cancelados");

        contadores.forEach(el => {
            // 1. Mostra o loader dentro do elemento de contagem
            showLoader(el, '');
        });
    };

    /**
     * Busca dados de estatísticas da API e atualiza a interface.
     * @param {string} tabela O nome da tabela a ser consultada.
     */
    async function carregarEstatisticas(tabela) {
        const caminhoAPI = './api_query/fetch_status.php'; // API que retorna JSON
        const tabelasParaQuery = tabelasPermitidas.join(',');

        // Cria um objeto FormData para enviar os dados no corpo da requisição
        const formData = new FormData();
        formData.append('nomeTabela', tabela);
        formData.append('tabelasPermitidas', tabelasParaQuery);

        try {
            // Realiza a requisição com o método POST e envia os dados no 'body'
            const response = await fetch(caminhoAPI, {
                method: 'POST',
                body: formData
            });

            // Lança um erro se a resposta HTTP não for bem-sucedida (ex: 404, 500)
            if (!response.ok) {
                throw new Error(`Erro na requisição: ${response.status} ${response.statusText}`);
            }

            // Converte o corpo da resposta em JSON
            const resultado = await response.json();
            loaderContadores();

            // Verifica o status LÓGICO retornado pelo seu script PHP
            if (resultado && resultado.status === 'success') {
                // loaderContadores();
                setTimeout(() => {
                    atualizarContadores(resultado.data);
                }, 700);
            } else {
                // console.error("Erro na lógica da API: " + (resultado.message || 'Resposta inválida'));
                // loaderContadores();
                setTimeout(() => {
                    atualizarContadores();
                }, 700);
            }

        } catch (error) {
            // Captura erros de rede ou falhas na conversão para JSON
            // loaderContadores();
            console.error("Falha na requisição fetch: ", error);
            atualizarContadores();
        }
    }



    /**
     * Exibe os dados carregados dentro do contêiner especificado, substituindo o loader.
     * @param {HTMLElement} containerElement - O elemento HTML onde os dados serão exibidos.
     * @param {string} htmlContent - O conteúdo HTML a ser inserido no contêiner.
     */
    function displayData(containerElement, htmlContent) {
        // Limpa o loader e insere o novo conteúdo
        containerElement.innerHTML = htmlContent;
    }


    /**
     * Mostra a animação de carregamento dentro do contêiner especificado.
     * @param {HTMLElement} containerElement - O elemento HTML onde o loader será exibido.
     * @param {string} message - A mensagem a ser exibida acima do loader.
     */
    function showLoader(containerElement, message = "Carregando dados, por favor aguarde...") {
        // Limpa o conteúdo anterior do contêiner
        containerElement.innerHTML = '';

        // Cria a mensagem de carregamento
        const messageElement = document.createElement('p');
        messageElement.className = 'loading-message';
        messageElement.textContent = message;

        // Cria o elemento do loader
        const loaderElement = document.createElement('div');
        loaderElement.className = 'loader';

        // Adiciona a mensagem e o loader ao contêiner
        containerElement.appendChild(messageElement);
        containerElement.appendChild(loaderElement);
    }

    /**
     * Função dinâmica para buscar dados e exibi-los em um container.
     * @param {string} id - O ID do elemento HTML onde os dados serão exibidos.
     * @param {Function} funcaoBuscaDados - A função assíncrona que buscará os dados.
     * @param {any} argsFiltro - Argumentos que serão passados para a funcaoBuscaDados.
     * @param {any} argsTabela - Argumentos que serão passados para a funcaoBuscaDados.
     */
    async function fetchcarregaDados(id, funcaoBuscaDados, argsFiltro, argsTabela) {
        carregarEstatisticas(argsTabela);
        showLoader(dataContainer);
        try {
            // 1. Executa a função de busca de dados que foi passada como parâmetro
            const dataHtml = await funcaoBuscaDados(argsFiltro, argsTabela);

            // 2. Exibe os dados retornados no elemento com o ID correspondente
            displayData(id, dataHtml);

        } catch (error) {
            console.error("Erro ao buscar ou exibir os dados:", error);
            // Opcional: esconder o loader e mostrar uma mensagem de erro
            // hideLoader();
            // displayError(id, "Não foi possível carregar os dados.");
        }
    };


    if (menuIcon) {

        menuIcon.addEventListener('click', () => {
            iconMenu();
            // Opcional: Gerenciar o atributo aria-expanded para acessibilidade
            const isExpanded = menuIcon.getAttribute('aria-expanded') === 'true';
            menuIcon.setAttribute('aria-expanded', !isExpanded);
            dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';

        });

        // Opcional: Definir o atributo aria-expanded inicial se ainda não estiver definido no HTML
        if (!menuIcon.hasAttribute('aria-expanded')) {
            menuIcon.setAttribute('aria-expanded', 'false');
        }

    }

    // Função para aplicar o padding correto
    function applyPadding() {
        if (menuIcon.classList.contains('fa-bars')) {
            menuIcon.style.padding = '10px 15px';
        } else {
            menuIcon.style.padding = '10px 16px';
        }
    };

    function iconMenu() {
        // Verifica se o ícone atual é o de barras
        if (menuIcon.classList.contains('fa-bars')) {
            // Remove a classe 'fa-bars' e adiciona 'fa-xmark'
            menuIcon.classList.remove('fa-bars');
            menuIcon.classList.add('fa-xmark');
            // Opcional: Adicione a classe 'active' para controle de estilos ou outras ações
            menuIcon.classList.add('active');
        } else {
            // Se não for o de barras, assume que é o 'X' e troca de volta para barras
            menuIcon.classList.remove('fa-xmark');
            menuIcon.classList.add('fa-bars');
            // Opcional: Remove a classe 'active'
            menuIcon.classList.remove('active');
        }
        applyPadding();
    }

    // Adiciona listeners de evento de clique a cada link no dropdown
    dropdownMenuLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            // Impede o comportamento padrão do link (navegar pela href)
            // activeTable = this.dataset.page;
            const page = this.dataset.page;
            // Obtém o valor do atributo data-page
            const pagedisplay = this.dataset.display;
            // Aqui você pode adicionar a lógica para navegar para a página específica

            tableSelect.textContent = pagedisplay;

            linksDoMenu.forEach(link => {
                if (link.classList.contains('active-li')) {
                    link.classList.remove('active-li');
                }
                // Se quiser, você pode adicionar a classe a outro link aqui
                // if (link.textContent === 'Sobre Nós') {
                //   link.classList.add('active');
                // }
            });

            loadContent(page, pagedisplay, 'todos'); // Carrega a nova tabela mantendo o filtro atual
            subpageTitle.textContent = activeSubpage;

            // updateActiveFilterLinkByFilter(dropdownMenuLinks, activeTable, 'menu');
            updateActiveFilterLinkByFilter(filterLinks, activeFilter, 'li');

        });
    });

    window.addEventListener('click', (event) => {
        // Verifica se o clique foi dentro do dropdown
        if (!menuIcon.contains(event.target)) {
            // console.log('verifica menu');

            if (menuIcon.classList.contains('fa-xmark')) {
                // console.log('fecha o menu');
                iconMenu();
                dropdownMenu.style.display = 'none';
            }
            // Fecha o dropdown
            //   fecharDropdown();
        }
    });

    // Links de filtro navbar
    filterLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();

            activeFilter = this.dataset.filter;
            activeSubpage = this.dataset.subtitle;

            // console.log(activeFilter);
            // console.log(textSubtitle);
            // console.log(activeTable);

            subpageTitle.textContent = activeSubpage;
            updateActiveFilterLinkByFilter(filterLinks, activeFilter, 'li');
            fetchcarregaDados(dataContainer, fetchDataWithJQuery, condicoesPage(activeFilter), activeTable);

        });
    });

    function condicoesPage(filtro) {
        let condicoes = '';
        switch (filtro) {
            case 'todos':
                condicoes = "./api_query/fetch_inscritos.php";
                break;
            case "pagos":
                condicoes = "./api_query/fetch_confirmados.php";
                break;
            case "isentos":
                condicoes = "./api_query/fetch_isentos.php";
                break;
            case "pendentes":
                condicoes = "./api_query/fetch_pendentes.php";
                break;
            case "desistente/cancelados":
                condicoes = "./api_query/fetch_cancelados.php";
                break;
            case "cupom":
                condicoes = "./api_query/fetch_cupom.php";
                break;
            case 'NomeCracha':
                condicoes = "./api_query/fetch_nomecracha.php";
                break;
            case 'Check-in-R':
                condicoes = "./api_query/fetch_check-in-r.php";
                break;
            case 'Check-in-P':
                condicoes = "./api_query/fetch_check-in-p.php";
                break;
            case 'Ordem pagamento':
                condicoes = "./api_query/fetch_datapag.php";
                break;
            case 'Ordem Isento':
                condicoes = "./api_query/fetch_datapag_sem.php";
                break;
            case "logout":
                window.location.href = "./logout";
                break;
        }
        return condicoes;
    }


    function fetchDataWithJQuery(dataUrl, tabela) {
        return new Promise((resolve, reject) => {
            const fallbackDataHtml = `
                <div class="loaded-data">
                    <span style='padding-top: 20px;font-weight: 700;font-size: 40px;'>
                        Nenhum dado encontrado!
                    </span>
                </div>`;

            // 1. Lógica para quando dataUrl está vazia ou nula
            if (!dataUrl) {
                console.warn("A URL de dados (dataUrl) está vazia. Usando dados de fallback.");
                // Resolve com o HTML de fallback imediatamente (ou com um delay, se preferir)
                return setTimeout(() => {
                    resolve(fallbackDataHtml);
                }, 1000);
            }

            const tabelasParaQuery = tabelasPermitidas.join(',');

            // Crie um objeto simples com os dados a serem enviados
            const dadosParaEnviar = {
                nomeTabela: tabela,
                tabelasPermitidas: tabelasParaQuery
            };

            // Passe o objeto como o segundo argumento do $.post
            $.post(dataUrl, dadosParaEnviar, function (retrievedData) {
                // Sucesso
                setTimeout(() => {
                    resolve(retrievedData);
                }, 1000);
            }).fail(function (jqXHR, textStatus, errorThrown) {
                // Falha na requisição
                console.error("Erro ao buscar dados com $.post(): ", textStatus, errorThrown);
                console.warn(`Não foi possível carregar de ${dataUrl}. Usando dados de fallback.`);

                // Resolve com o HTML de fallback em caso de erro
                setTimeout(() => {
                    resolve(fallbackDataHtml);
                }, 1000);
            });
        });
    }

    /**
    * Atualiza o link ativo com base no valor do filtro.
    * @param {NodeListOf<Element>} elements - A lista de todos os elementos de filtro.
    * @param {string} activeFilterValue - O valor do data-filter que deve estar ativo.
    */
    function updateActiveFilterLinkByFilter(elements, activeFilterValue, classElement) {
        elements.forEach(element => {
            // Remove a classe 'active' de todos os elementos
            element.classList.remove('active-' + classElement);

            // Adiciona a classe 'active' apenas ao elemento cujo data-filter corresponde ao activeFilterValue
            if (element.dataset.filter === activeFilterValue) {
                element.classList.add('active-' + classElement);
            }
        });
    }


    window.get_param = async function (el) {
        // 1. Coleta os dados do elemento
        const dataId = el.getAttribute("data-id");
        const dataVal = el.getAttribute("data-v");
        const tableName = el.getAttribute("data-tb");
        let apiUrl = './api_query/update_dash.php';
        let requires = false;

        let textoConfirmacao;
        let icone;

        // 2. Define o texto e o ícone para o alerta
        switch (dataVal) {
            case 'Confirmado':
                textTexto = 'confirmar'
                icone = 'question';
                break;
            case 'Isento':
                icone = 'info';
                break;
            case 'Cancelado':
                textTexto = 'cancelar'
                icone = 'warning';
                requires = true;
                break;
            case 'Excluir':
                textTexto = 'excluir'
                icone = 'warning';
                apiUrl = './api_query/delete_dash.php';
                break;
            default:
                console.error("Ação desconhecida:", dataVal);
                return;
        }

        // 3. Exibe o alerta do SweetAlert2
        atualizarStatus({
            tableName: tableName,
            dataId: dataId,
            newStatus: dataVal, // O valor do status que você envia para o back-end
            newTexto: textTexto,
            newIcone: icone,
            newApiurl: apiUrl,
            requiresReason: requires     // Ponto chave: precisa de motivo

        });
    }

    async function atualizarStatus(config) {
        // Configuração base do Swal
        const swalOptions = {
            title: 'Você tem certeza?',
            text: `Deseja realmente ${config.newTexto} esta inscrição?`,
            icon: config.newIcone,
            showCancelButton: true,
            confirmButtonColor: '#2b734c',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, continuar!',
            cancelButtonText: 'Não'
        };

        // Adiciona o campo de motivo APENAS se for necessário
        if (config.requiresReason) {
            swalOptions.input = 'textarea';
            swalOptions.inputLabel = 'Motivo';
            swalOptions.inputPlaceholder = 'Por favor, descreva o motivo do cancelamento...';
            swalOptions.inputValidator = (value) => {
                if (!value) {
                    return 'Você precisa escrever um motivo!';
                }
            };
        }

        // Exibe o Swal com as configurações definidas
        Swal.fire(swalOptions).then(async (result) => {
            // Se o usuário clicou no botão de confirmação
            if (result.isConfirmed) {

                // Define o motivo: pega do input se existir, senão define como null
                const dataMotivo = config.requiresReason ? result.value : null;

                const formButton = new FormData();
                formButton.append('tabela', config.tableName);
                formButton.append('codparceiro', config.dataId);
                formButton.append('status', config.newStatus);
                formButton.append('motivo', dataMotivo); // Envia o motivo (seja o texto ou null)

                try {
                    const response = await fetch(config.newApiurl, { // assumindo que 'apiUrl' é uma variável global
                        method: 'POST',
                        body: formButton
                    });

                    if (!response.ok) {
                        throw new Error(`Erro HTTP: ${response.status}`);
                    }

                    const resultado = await response.json();

                    if (resultado && resultado.status === 'success') {
                        Swal.fire({
                            icon: "success",
                            title: "Atualizado!",
                            text: resultado.message || 'A operação foi concluída com sucesso.',
                            showConfirmButton: false,
                            timer: 1500,
                            willClose: () => {
                                // Atualiza seu conteúdo, se necessário
                                loadContent(activeTable, activeTableDisplay, activeFilter);
                            },
                        });
                    } else {
                        Swal.fire('Erro!', resultado.message || 'Não foi possível concluir a operação.', 'error');
                    }
                } catch (error) {
                    console.error("Falha na requisição fetch: ", error);
                    Swal.fire('Erro de Conexão!', 'Não foi possível comunicar com o servidor.', 'error');
                }
            }
        });

    }

    window.getQrcodeParam = async function (el) {
        // window.getQrcodeParam(el) {
        var valid = $(el).attr("data-id");
        var namee = $(el).attr("data-nome");
        // const palavras = namee.split(" ");
        // const primeiraPalavra = palavras[0];
        // console.log(palavras, primeiraPalavra, valid);

        $.ajax({
            method: "POST",
            url: "./api_query/fetch_qrcode_getv1.php",
            data: { id: valid, nome: namee },
            success: function (response) {
                // console.log(response);

                if (response.error) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: response.message,
                        // footer: '<a href="#">Why do I have this issue?</a>'
                    });
                } else {
                    Swal.fire({
                        // icon: "error",
                        // title: "Oops...11",
                        showConfirmButton: false,
                        html: response,
                        footer:
                            '<button id="btn_download" class="btn btn-outline-success button button1">Download</button>',
                    });

                    // Seletor para a div que você deseja salvar
                    const divToDownload = document.querySelector("#crachar_download");
                    // Seletor para o botão de download
                    const downloadButton = document.getElementById("btn_download");
                    downloadButton.addEventListener("click", downloadDivAsImage);

                    function downloadDivAsImage() {
                        // Crie um elemento de imagem
                        const image = document.createElement("img");
                        // console.log(divToDownload);


                        // Converta a div em uma imagem usando o DOMtoImage
                        domtoimage
                            .toPng(divToDownload)
                            .then(function (dataUrl) {
                                // Defina o atributo 'src' da imagem
                                image.src = dataUrl;

                                // Crie um link para download
                                const link = document.createElement("a");
                                link.href = dataUrl;
                                link.download = "Qrcode_" + namee + ".jpg";

                                // Anexe a imagem ao link
                                link.appendChild(image);

                                // Simule um clique no link para iniciar o download
                                link.click();
                            })
                            .catch(function (error) {
                                console.error("Erro ao converter a div em imagem:", error);
                            });
                    }
                }
            },
        });
    }


    // Para inicializar o estado visual na primeira carga da página
    initializeDashboard();
    applyPadding();
    // loadContent(urlCaminho, activeTable);


});

