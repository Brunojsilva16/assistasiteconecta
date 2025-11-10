function scrollSmoothPage(id) {
    var elmnt = document.getElementById(id);
    elmnt.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

$(".botao-sombra1").on("click", function (e) {
    e.preventDefault();

    goToStep('step-1');

    // $.post('./forms/tus-lote_dados_frm.php', function (retorna) {

    limparCamp();
    // $("#frmInsc_lote").html(retorna);

    var el = document.getElementById('teforms');
    var ellote = document.getElementById('lotes');
    var eldiv = document.getElementById('pagament1');
    el.style.display = "flex";
    eldiv.style.display = "none";
    eldiv.style.transition = "transform 0.4s ease";
    ellote.style.paddingBottom = '16px';
    //  el.setAttribute('padding-top','150px');

    $("#value-lote-select").val("127,90");
    $(".lote_select").text('normal');

    scrollSmoothPage('teforms');
    callMaskRes();

    // });

});

document.addEventListener('DOMContentLoaded', callMaskRes);

function callMaskRes() {
    // Máscara para Telefone: (99) 99999-9999
    $('#telefone').mask('(00) 00000-0000');
    // Máscara para CPF: 999.999.999-99
    $('#cpf').mask('000.000.000-00')
}

// --- LÓGICA DO FORMULÁRIO ---

// URL do seu script de API no backend (ex: um arquivo PHP)
const urlApiCheck = './api_query/fetch_exist.php';
const urlApiSave = './api_query/fetch_tus_insert.php';
const urlApiCupum = './api_query/update_cupom.php';

// Função para navegar entre os steps
const steps = document.querySelectorAll('.step');
const formState = {
    email: '',
    cpf: '',
    valor: '127,90',
    cupom: '',
    categoria: 'normal',
    id_participante: ''
};

// Função para navegar entre os steps
function goToStep(stepId) {
    steps.forEach(step => {
        step.classList.remove('active');
    });
    document.getElementById(stepId).classList.add('active');
}

// Função para mostrar/esconder o spinner
function setLoading(loaderId, isLoading) {
    const loader = document.getElementById(loaderId);
    loader.style.display = isLoading ? 'block' : 'none';
}

// Função para exibir mensagens de erro
function showMessage(messageId, text) {
    const messageEl = document.getElementById(messageId);
    messageEl.textContent = text;
}

// --- VERIFICAÇÕES NO BACKEND (VIA FETCH API) ---

// Verifica se um cupom já existe no banco de dados
async function checkCupomExists(cupom) {
    setLoading('loader-cupom', true);
    showMessage('message-cupom', '');

    const formData = new FormData();
    formData.append('action', 'check_cupom');
    formData.append('cupom', cupom);
    formData.append('nomeTabela', 'codigo');

    try {
        const response = await fetch(urlApiCheck, {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error(`Erro na requisição:`);
        }

        const resultado = await response.json();

        // A API deve retornar { "exists": true } ou { "exists": false }
        return resultado.exists;

    } catch (error) {
        console.error("Falha ao verificar cupom:", error);
        showMessage('message-cupom', 'Não foi possível conectar ao servidor. Tente novamente.');
        return false; // Assumir que não existe em caso de erro de rede
    } finally {
        setLoading('loader-cupom', false);
    }
}

// Verifica se um email já existe no banco de dados
async function checkEmailExists(email) {
    setLoading('loader-email', true);
    showMessage('message-email', '');

    const formData = new FormData();
    formData.append('action', 'check_email');
    formData.append('email', email);
    formData.append('nomeTabela', 'workshop_tus');

    try {
        const response = await fetch(urlApiCheck, {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error(`Erro na requisição:`);
        }

        const resultado = await response.json();

        // A API deve retornar { "exists": true } ou { "exists": false }
        return resultado.exists;

    } catch (error) {
        console.error("Falha ao verificar e-mail:", error);
        showMessage('message-email', 'Não foi possível conectar ao servidor. Tente novamente.');
        return false; // Assumir que não existe em caso de erro de rede
    } finally {
        setLoading('loader-email', false);
    }
}

// Verifica se um CPF já existe
async function checkCpfExists(cpf) {
    setLoading('loader-cpf', true);
    showMessage('message-cpf', '');

    const formData = new FormData();
    formData.append('action', 'check_cpf');
    formData.append('cpf', cpf);
    formData.append('nomeTabela', 'workshop_tus');

    try {
        const response = await fetch(urlApiCheck, {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error(`Erro na requisição: ${response.status}`);
        }

        const resultado = await response.json();
        // A API deve retornar { "exists": true } ou { "exists": false }
        return resultado.exists;

    } catch (error) {
        console.error("Falha ao verificar CPF:", error);
        showMessage('message-cpf', 'Não foi possível conectar ao servidor. Tente novamente.');
        return false;
    } finally {
        setLoading('loader-cpf', false);
    }
}

async function updateNewUser() {
    setLoading('loader-cupom', true);
    showMessage('message-cupom', '');

    const formData = new FormData();
    formData.append('cupom', formState.cupom);
    formData.append('valor', formState.valor);
    formData.append('categoria', formState.categoria);
    formData.append('id', formState.id_participante);
    formData.append('nomeTabela', 'workshop_tus');

    try {
        const response = await fetch(urlApiCupum, {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error(`Erro na requisição: ${response.status}`);
        }

        const resultado = await response.json();
        // A API deve retornar { "exists": true } ou { "exists": false }
        return resultado.status;

    } catch (error) {
        console.error("Falha ao verificar Cupom:", error);
        showMessage('message-cupom', 'Não foi possível conectar ao servidor. Tente novamente.');
        return false;
    } finally {
        setLoading('loader-cupom', false);
    }
}

// Salva os dados completos do novo usuário
async function saveNewUser() {
    const formData = new FormData();
    formData.append('action', 'save_user');
    formData.append('nome', document.getElementById('nome').value);
    formData.append('email', formState.email);
    formData.append('cpf', formState.cpf);
    formData.append('categoria', formState.categoria);
    formData.append('telefone', document.getElementById('telefone').value);

    // Remove "R$ " e o espaço
    let valorSemSimbolo = formState.valor.replace("R$ ", "");
    formData.append('valor', valorSemSimbolo);

    // 1. Encontrar o input do arquivo
    const fileInput = document.getElementById('imagefile');

    // 2. Verificar se um arquivo foi selecionado
    if (fileInput.files.length > 0) {
        // 3. Obter o arquivo
        const file = fileInput.files[0];
        // 4. Anexar o arquivo ao FormData. 
        // O nome 'docfile' deve corresponder ao `name` do seu input e ao que o backend espera.
        formData.append('docfile', file);
    }

    // for (var pair of formData.entries()) {
    //     console.log(pair[0] + ': ' + (pair[1] instanceof File ? pair[1].name : pair[1]));
    // }

    // Simulação de salvamento - substitua pela sua chamada de API real
    try {
        const response = await fetch(urlApiSave, {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error(`Erro na requisição: ${response.status}`);
        }

        const resultado = await response.json();
        if (resultado.status === 'success') {
            formState.id_participante = resultado.id_participante;
            console.log(resultado);
            // console.log("Usuário salvo com sucesso!");
            return true;
        } else {
            throw new Error(resultado.message || 'Erro desconhecido ao salvar.');
        }

    } catch (error) {
        console.error("Erro ao salvar usuário: ", error);
        Swal.fire({
            icon: 'error',
            title: 'Falha ao Salvar',
            text: `Não foi possível salvar sua inscrição: ${error.message}`
        });
        return false;
    }
    // return true;
}

function modalidade(estado) {

    setLoading('cupomParceiro', true);
    setLoading('pague', true);
    setLoading('precce', false);

    switch (estado) {
        case 'normal':
            document.getElementById('sumary-pagamento').innerHTML = `
            <a href="https://pag.ae/7_GFD-pHM/button" target="_blank" title="Pagar com PagBank"><img src="https://assets.pagseguro.com.br/ps-integration-assets/botoes/pagamentos/205x30-pagar.gif" alt="Pague com PagBank - é rápido, grátis e seguro!" /></a>`;
            document.getElementById('disclaimer-text').innerHTML = `*Sua inscrição será confirmada após a aprovação do pagamento.`;

            break;
        case 'desconto':
            document.getElementById('sumary-pagamento').innerHTML = `
            <a href="https://pag.ae/7__UaFiNM/button" target="_blank" title="Pagar com PagBank"><img src="https://assets.pagseguro.com.br/ps-integration-assets/botoes/pagamentos/205x30-pagar-laranja.gif" alt="Pague com PagBank - é rápido, grátis e seguro!" /></a>`;
            document.getElementById('disclaimer-text').innerHTML = `*Sua inscrição será confirmada após a aprovação do pagamento.`;

            break;
        case 'isento':
            document.getElementById('sumary-pagamento').innerHTML = `<p>Inscrição gratuita.</p>`;
            document.getElementById('disclaimer-text').innerHTML = `*Sua inscrição será confirmada após a confirmação de participação na Imersão.`;
            break;

        default:
            break;
    }

    return;
}

document.getElementById('btn-botCupom').addEventListener('click', async () => {
    const cupomInput = document.getElementById('cupomParc');
    if (!cupomInput.checkValidity()) {
        showMessage('message-cupom', 'Por favor, insira um cupom válido.');
        return;
    }
    formState.cupom = cupomInput.value.trim();

    const exists = await checkCupomExists(formState.cupom);

    if (exists) {

        if (exists['status'] > 0) {
            // setLoading('pague', false);
            // setLoading('precce', true);

            // formData.append('cupom', formState.cupom);

            if (formState.cupom == 'ASSISTA') {
                formState.valor = '0,0';
                formState.categoria = 'isento';
            } else {
                formState.valor = '102,30';
                formState.categoria = 'desconto';
            }

            const savedupdate = await updateNewUser();

            if (savedupdate) {
                Swal.fire({
                    position: "top",
                    icon: "success",
                    // title: "Sucesso!",
                    text: "Novo valor adicionado a sua compra!",
                    showConfirmButton: false,
                    timer: 2000
                });

                modalidade(formState.categoria);
                cupomInput.disabled = true;
                document.getElementById('btn-botCupom').disabled = true;
                document.getElementById('message-cupom').textContent = 'Cupom aplicado'
                document.getElementById('summary-value').textContent = formState.valor;


            } else {

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    // text: 'Cupom não fornecido ou inválido',
                    // footer: '<a href="#">Why do I have this issue?</a>'
                });
            }
        } else {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: 'Cupom Expirado ou desativado!',
                // footer: '<a href="#">Why do I have this issue?</a>'
            });
        }
    } else {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: 'Cupom incorreto ou inválido',
            // footer: '<a href="#">Why do I have this issue?</a>'
        });
    }
});

document.getElementById('btn-check-email').addEventListener('click', async () => {
    const emailInput = document.getElementById('email');
    if (!emailInput.checkValidity()) {
        showMessage('message-email', 'Por favor, insira um e-mail válido.');
        return;
    }
    formState.email = emailInput.value.trim();

    const exists = await checkEmailExists(formState.email);
    if (exists) {

        if (exists['status_insc'] == 'Confirmado' || exists['status_insc'] == 'Isento') {
            setLoading('cupomParceiro', false);
            setLoading('pague', false);
            setLoading('precce', true);

            document.getElementById('step-final').style.display = 'none';
            document.getElementById('sumary-p-label').style.display = 'none';

            document.getElementById('summary-name').textContent = exists['nome_insc'];
            document.getElementById('summary-modality').textContent = "Workshop Tus";
            document.getElementById('step-confirm').textContent = `Sua inscrição já está confirmada.`;

            document.getElementById('precce').innerHTML = `
                <p style="margin: 1rem 1rem 0 1rem; font-size: 13px; text-align: center;">
                    Eu estou muito feliz em te dizer: seja muito bem-vinda(o).
                    Com carinho,
                </p>
                <p style="font-size: 12px; text-align: center;">Vanessa e Equipe Assista Conecta.</p>
                <p style="margin: 0 1rem; font-size: 12px; text-align: center;">
                    Caso não receba o e-mail, entre em contato com nossa equipe de suporte.<br>
                    (81) 99641 9472 <i class="fab fa-whatsapp"></i>
                </p>
            `;

        } else {

            modalidade(exists['categoria_insc']);

            document.getElementById('summary-name').textContent = exists['nome_insc'];
            document.getElementById('step-confirm').textContent = `Participante com e-mail já cadastrado.*`;
            document.getElementById('summary-modality').textContent = "Workshop Tus";
            document.getElementById('summary-value').textContent = exists['valor_insc'];
            document.getElementById('sumary-p-label').style.display = 'none';
            document.getElementById('step-final').style.display = 'none';
            formState.id_participante = exists['id_insc'];
        }

        goToStep('step-4');
    } else {
        goToStep('step-2');

    }
});

document.getElementById('btn-check-cpf').addEventListener('click', async () => {
    const cpfInput = document.getElementById('cpf');
    if (cpfInput.value.length < 14) {
        showMessage('message-cpf', 'Por favor, insira um CPF válido.');
        return;
    }
    formState.cpf = cpfInput.value.trim();

    const exists = await checkCpfExists(formState.cpf);

    if (exists) {

        if (exists['status_insc'] == 'Confirmado' || exists['status_insc'] == 'Isento') {
            setLoading('pague', false);
            setLoading('precce', true);

            document.getElementById('step-final').style.display = 'none';
            document.getElementById('sumary-p-label').style.display = 'none';

            document.getElementById('summary-name').textContent = exists['nome_insc'];
            document.getElementById('summary-modality').textContent = "Workshop Tus";
            document.getElementById('step-confirm').textContent = `Sua inscrição já está confirmada.`;

            document.getElementById('precce').innerHTML = `
                <p style="margin: 1rem 1rem 0 1rem; font-size: 13px; text-align: center;">
                    Eu estou muito feliz em te dizer: seja muito bem-vinda(o).
                    Com carinho,
                </p>
                <p style="font-size: 12px; text-align: center;">Vanessa e Equipe Assista Conecta.</p>
                <p style="margin: 0 1rem; font-size: 12px; text-align: center;">
                    Caso não receba o e-mail, entre em contato com nossa equipe de suporte.<br>
                    (81) 99641 9472 <i class="fab fa-whatsapp"></i>
                </p>
            `;

        } else {

            modalidade(exists['categoria_insc']);

            document.getElementById('summary-name').textContent = exists['nome_insc'];
            document.getElementById('step-confirm').textContent = `Participante com cpf já cadastrado.*`;
            document.getElementById('summary-modality').textContent = "Workshop Tus";
            document.getElementById('summary-value').textContent = exists['valor_insc'];
            document.getElementById('sumary-p-label').style.display = 'none';
            document.getElementById('step-final').style.display = 'none';
            formState.id_participante = exists['id_insc'];
        }

        goToStep('step-4');
    } else {
        document.getElementById('final_email').value = formState.email;
        document.getElementById('final_cpf').value = formState.cpf;
        document.getElementById('docUp').style.display = 'block';

        goToStep('step-3');
    }
});

document.getElementById('btn-to-payment').addEventListener('click', async () => {
    const nomeDigitado = document.getElementById('nome');
    const telefoneDigitado = document.getElementById('telefone');

    // --- FIM DA MODIFICAÇÃO DE VALIDAÇÃO ---

    let nomeLimpo = nomeDigitado.value.trim();
    let telefoneLimpo = telefoneDigitado.value.trim();

    var names = nomeLimpo.split(' ');
    if (nomeLimpo === '') {
        Swal.fire({
            icon: 'warning',
            title: 'O campo Nome é obrigatório',
            text: 'Por favor, preencha todos os campos obrigatórios.'
        });
        // Você pode adicionar mais lógica aqui, como focar no campo ou exibir uma mensagem de erro em um elemento HTML.
        nomeDigitado.focus();
        return; // Impede o envio do formulário ou prosseguimento.
    }
    if (names.length < 2 || names[0].length === 0 || names[1].length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Insira seu nome completo.',
            text: 'Com pelo menos o primeiro e segundo nome.'
        });
        nomeDigitado.focus();
        return;
    }

    if (telefoneLimpo === '') {
        Swal.fire({
            icon: 'warning',
            title: 'O campo Telefone é obrigatório',
            text: 'Por favor, preencha todos os campos obrigatórios.'
        });
        // Você pode adicionar mais lógica aqui, como focar no campo ou exibir uma mensagem de erro em um elemento HTML.
        telefoneDigitado.focus();
        return; // Impede o envio do formulário ou prosseguimento.
    }
    if (telefoneLimpo.length < 15) {
        Swal.fire({
            icon: 'warning',
            title: 'Campo obrigatório.',
            text: 'Verifique os digitos do número de telefone!.'
        });
        telefoneDigitado.focus();
        return;
    }

    const saved = await saveNewUser();
    if (saved) {
        document.getElementById('summary-name').textContent = nomeLimpo;
        document.getElementById('summary-modality').textContent = formState.modalidade;
        document.getElementById('summary-value').textContent = formState.valor;

        modalidade(formState.categoria);

        enviaDados(formState.email);

        Swal.fire({
            position: "top",
            showConfirmButton: false,
            timer: 2500,
            footer: "<p>Aguarde, processando requisição...</P><br><img src='./assets/img/loading03.gif' style='width: 50%;'>"
        });

        goToStep('step-4');
    }
});

function limparCamp() {
    $('form')[0].reset();
    $('#value-lote-select').val('');
    $('.lote_select').text('');
    $('.file-name').text('Nenhum arquivo selecionado');
}

document.querySelectorAll('button[data-action="back"]').forEach(button => {
    button.addEventListener('click', (e) => {
        const targetStep = e.currentTarget.getAttribute('data-target');
        goToStep(targetStep);
    });
});

function checkUpload() {
    const fileInput = document.getElementById('imagefile');
    const fileNameDisplay = document.getElementById('file-name');

    fileInput.addEventListener('change', function () {
        if (this.files && this.files.length > 0) {
            fileNameDisplay.textContent = this.files[0].name;
        } else {
            fileNameDisplay.textContent = 'Nenhum arquivo selecionado';
        }
    });
}

function enviaDados(email) {
    var dados = {
        email: email
    }
    $.post('./includes/output_workshop.php', dados, function () {
        return true;
    });
}