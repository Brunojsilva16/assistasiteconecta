
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
const urlApiSave = './api_query/fetch_insert_c.php';

// Função para navegar entre os steps
const steps = document.querySelectorAll('.step');
const formState = {
    email: '',
    cpf: '',
    modalidade: '',
    modalidade_status: '',
    envio: '',
    valor: ''
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

// Verifica se um email já existe no banco de dados
async function checkEmailExists(email) {
    setLoading('loader-email', true);
    showMessage('message-email', '');

    const formData = new FormData();
    formData.append('action', 'check_email');
    formData.append('email', email);
    formData.append('nomeTabela', 'colonia_te');

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
    formData.append('nomeTabela', 'colonia_te');

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

// Salva os dados completos do novo usuário
async function saveNewUser() {
    const formData = new FormData();
    formData.append('action', 'save_user');
    formData.append('nome', document.getElementById('nome').value);
    formData.append('responsavel', document.getElementById('responsavel').value);
    formData.append('email', formState.email);
    formData.append('cpf', formState.cpf);
    formData.append('telefone', document.getElementById('telefone').value);
    formData.append('lote', '1');
    formData.append('modalidade', formState.modalidade);
    formData.append('responsavel', document.getElementById('responsavel').value);

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
            console.log("Usuário salvo com sucesso!");
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

function modalidade(valor) {

    switch (valor) {

        case '11/07':
            setLoading('pague', true);
            setLoading('precce', false);
            formState.envio = 'onze';
            formState.modalidade_status = 'Atividade no dia 11/07'
            document.getElementById('sumary-pagamento').innerHTML = `
                        <a href="https://pag.ae/7_NmTceCQ/button" target="_blank" title="Pagar com PagBank">
                            <img src="//assets.pagseguro.com.br/ps-integration-assets/botoes/pagamentos/205x30-pagar.gif" 
                                alt="Pague com PagBank - é rápido, grátis e seguro!" />
                        </a>
                    `;
            break;

        case '18/07':
            setLoading('pague', true);
            setLoading('precce', false);
            formState.envio = 'dezoito';
            formState.modalidade_status = 'Atividade no dia 18/07'
            document.getElementById('sumary-pagamento').innerHTML = `
                        <a href="https://pag.ae/7_NmTceCQ/button" target="_blank" title="Pagar com PagBank">
                            <img src="//assets.pagseguro.com.br/ps-integration-assets/botoes/pagamentos/205x30-pagar.gif" 
                                alt="Pague com PagBank - é rápido, grátis e seguro!" />
                        </a>
                    `;
            break;

        case 'Dois dias':
            setLoading('pague', true);
            setLoading('precce', false);
            formState.envio = 'dois';
            formState.modalidade_status = 'Atividades nos dias 11/07 e 18/07'
            document.getElementById('sumary-pagamento').innerHTML = `
                        <a href="https://pag.ae/7_NmUtGB3/button" target="_blank" title="Pagar com PagBank">
                            <img src="//assets.pagseguro.com.br/ps-integration-assets/botoes/pagamentos/205x30-pagar.gif" 
                                alt="Pague com PagBank - é rápido, grátis e seguro!" />
                        </a>
                    `;
            break;
    }
    return;
}

// --- EVENT LISTENERS DOS BOTÕES ---
document.getElementById('btn-to-email').addEventListener('click', () => {
    const selectedRadio = document.querySelector('input[name="loteone_radio"]:checked');
    if (selectedRadio) {
        // --- INÍCIO DA MODIFICAÇÃO ---
        // 1. Captura o valor da modalidade (como já fazia)
        formState.modalidade = selectedRadio.value;

        // 2. Encontra a label associada ao radio selecionado
        const label = selectedRadio.nextElementSibling;

        // 3. Dentro da label, encontra o span com a classe 'xvista'
        const spanVista = label.querySelector('.xvista');

        // 4. Salva o texto do span no formState (remove espaços extras)
        if (spanVista) {
            formState.valor = spanVista.textContent.trim();
        }

        // 5. (Opcional) Exibe no console para depuração
        // console.log('Modalidade:', formState.modalidade);
        // console.log('Valor à vista:', formState.valor);

        // --- FIM DA MODIFICAÇÃO ---
        document.getElementById('modalidade-display').textContent = formState.modalidade;
        goToStep('step-1');

    } else {
        Swal.fire({
            icon: 'warning',
            title: 'Atenção',
            text: 'Por favor, selecione uma modalidade para continuar.'
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
            setLoading('pague', false);
            setLoading('precce', true);

            switch (exists['categoria_insc']) {
                case '11/07':
                    formState.modalidade_status = 'Atividade no dia 11/07'
                    break;
                case '18/07':
                    formState.modalidade_status = 'Atividade no dia 18/07'
                    break;
                case 'Dois dias':
                    formState.modalidade_status = 'Atividades nos dias 11/07 e 18/07'
                    break;
            }
            document.getElementById('step-final').style.display = 'none';
            // document.getElementById('sumary-p-label').style.display = 'bloc';
            document.getElementById('summary-name').textContent = exists['nome_insc'];
            document.getElementById('summary-modality').textContent = formState.modalidade_status;
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
            document.getElementById('summary-modality').textContent = formState.modalidade_status;
            // document.getElementById('sumary-p-label').style.display = 'block';
            document.getElementById('summary-value').textContent = 'R$ ' + exists['valor_insc'];
            document.getElementById('step-final').style.display = 'none';
        }

        goToStep('step-4');
    } else {
        goToStep('step-2');

    }
});

document.getElementById('btn-check-cpf').addEventListener('click', async () => {
    const cpfInput = document.getElementById('cpf');
    console.log(cpfInput.value.length);
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
            document.getElementById('summary-modality').textContent = formState.modalidade_status;
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
            document.getElementById('summary-modality').textContent = formState.modalidade_status;
            document.getElementById('summary-value').textContent = 'R$ ' + exists['valor_insc'];
            document.getElementById('step-final').style.display = 'none';
        }

        goToStep('step-4');
    } else {
        document.getElementById('final_email').value = formState.email;
        document.getElementById('final_cpf').value = formState.cpf;
        document.getElementById('docUp').style.display = 'none';

        // if (formState.modalidade == 'Profissional' || formState.modalidade == 'Grupo') {
        //     document.getElementById('docUp').style.display = 'none';
        // } else {
        //     document.getElementById('docUp').style.display = 'block';
        //     checkUpload();
        // }

        goToStep('step-3');
    }
});

document.getElementById('btn-to-payment').addEventListener('click', async () => {
    const nomeDigitado = document.getElementById('nome');
    const telefoneDigitado = document.getElementById('telefone');
    // const crachaDigitado = document.getElementById('cracha');

    //   // --- INÍCIO DA MODIFICAÇÃO DE VALIDAÇÃO ---
    // const fileInput = document.getElementById('imagefile');
    // const docUpContainer = document.getElementById('docUp');

    // // Verifica se o campo de upload está visível (exigido) e se um arquivo foi selecionado
    // if (docUpContainer.style.display !== 'none' && fileInput.files.length === 0) {
    //     Swal.fire({
    //         icon: 'warning',
    //         title: 'Comprovante Necessário',
    //         text: 'Para esta modalidade, você precisa anexar um arquivo comprovante.'
    //     });
    //     return; // Impede o prosseguimento
    // }
    // --- FIM DA MODIFICAÇÃO DE VALIDAÇÃO ---

    let nomeLimpo = nomeDigitado.value.trim();
    let telefoneLimpo = telefoneDigitado.value.trim();
    // let crachaLimpo = crachaDigitado.value.trim();

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

    // if (crachaLimpo === '') {

    //     Swal.fire({
    //         icon: 'warning',
    //         title: 'O campo Crachá é obrigatório',
    //         text: 'Por favor,\npreencha todos os campos obrigatórios.'
    //     });
    //     // Você pode adicionar mais lógica aqui, como focar no campo ou exibir uma mensagem de erro em um elemento HTML.
    //     return; // Impede o envio do formulário ou prosseguimento.
    // }

    const saved = await saveNewUser();
    if (saved) {
        modalidade(formState.modalidade);
        document.getElementById('summary-name').textContent = nomeLimpo;
        document.getElementById('summary-modality').textContent = formState.modalidade_status;
        document.getElementById('summary-value').textContent = formState.valor;


        enviaDadosColonia(formState.email, formState.envio);


        // enviaDados(formState.email);

        Swal.fire({
            position: "top",
            showConfirmButton: false,
            timer: 2500,
            footer: "<p>Aguarde, processando requisição...</P><br><img src='./assets/img/loading03.gif' style='width: 50%;'>"
        });

        goToStep('step-4');
    }
});

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

function enviaDadosColonia(email, cate) {
    var dados = {
        email: email,
        categoria: cate
    }
    $.post('./includes/output_cote.php', dados, function () {
        return true;
    });
}
// function enviaDadosDezoito(email) {
//     var dados = {
//         email: email
//     }
//     $.post('./includes/output_te.php', dados, function () {
//         return true;
//     });
// }

// function enviaDadosDois(email) {
//     var dados = {
//         email: email
//     }
//     $.post('./includes/output_cce_te.php', dados, function () {
//         return true;
//     });
// }

// document.getElementById('btn-restart').addEventListener('click', () => {

//     window.location.reload();

// document.getElementById('frmInsc_lote').reset();
// formState.email = '';
// formState.cpf = '';
// formState.modalidade = '';
// formState.valor = '';
// document.getElementById('summary-value').style.display = 'block';
// showMessage('message-email', '');
// showMessage('message-cpf', '');
// goToStep('step-0');
// });