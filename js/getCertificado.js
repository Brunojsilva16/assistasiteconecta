function getCertificado(button) {
    // Pega os dados do botão a partir dos atributos data-*
    const data = button.dataset;
    console.log(data);

    // --- INÍCIO DA MODIFICAÇÃO ---
    // Adiciona o pop-up de confirmação antes de fazer qualquer outra coisa.
    Swal.fire({
        title: 'Confirmar Envio',
        text: `Deseja realmente enviar o certificado para ${data.email}?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, enviar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        // O código de envio só será executado se o usuário clicar em "Sim, enviar!"
        if (result.isConfirmed) {

            // Desativa o botão e mostra um feedback para o usuário
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';

            // Prepara os dados para serem enviados via POST
            const formData = new FormData();
            formData.append('nome', data.nome);
            formData.append('email', data.email);
            formData.append('evento', data.evento);
            formData.append('palestrante', data.palestrante);
            formData.append('data', data.data);
            formData.append('cargaH', data.cargah);
            formData.append('local', data.local);

            // Endpoint: O arquivo PHP que vai processar o envio
            const apiEndpoint = './api_query/api_enviar_certificado.php';

            // Envia os dados para o servidor usando a API Fetch (AJAX)
            fetch(apiEndpoint, {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro de rede ou no servidor.');
                    }
                    return response.json(); // Converte a resposta do PHP para um objeto JSON
                })
                .then(result => {
                    // Processa a resposta do PHP
                    if (result.error) {
                        Swal.fire({
                            icon: "error", // Ícone de erro
                            title: "Erro!",
                            text: result.message || 'Falha ao enviar.', // Usa a mensagem do PHP ou um padrão
                            showConfirmButton: true // Botão de confirmação adicionado
                        });
                        // Reativa o botão em caso de erro no envio para nova tentativa
                        button.disabled = false;
                        button.innerHTML = '<i class="fas fa-check"></i> Enviar Certificado';

                    } else {
                        Swal.fire({
                            icon: "success",
                            title: "Enviado!", // Título mais apropriado
                            text: result.success || 'O e-mail foi enviado com sucesso.',
                            showConfirmButton: false, // Botão de confirmação adicionado
                            timer: 2000,
                            willClose: () => {
                                updateSendEmail(data.id, data.nometable);
                            },

                        });
                        button.innerHTML = '<i class="fas fa-check-circle"></i> Enviado!';
                        // Mantém o botão desativado para não enviar duas vezes
                    }
                })
                .catch(error => {
                    // Captura erros de conexão ou do processo
                    Swal.fire({
                        icon: "error", // Ícone de erro
                        title: "Erro!",
                        text: 'Ocorreu um erro inesperado. Tente novamente.', // Mensagem de erro padronizada
                        showConfirmButton: true // Botão de confirmação adicionado
                    });
                    // Reativa o botão em caso de erro
                    button.disabled = false;
                    button.innerHTML = '<i class="fas fa-check"></i> Enviar Certificado';
                });
        }
    });
    // --- FIM DA MODIFICAÇÃO ---
}


/**
 * Função assíncrona para atualizar o status do e-mail no backend.
 * Agora com tratamento de erros e feedback para o usuário.
 * @param {number|string} id - O ID do registro a ser atualizado.
 * @param {string} nometable - Nome da tabela
 */
async function updateSendEmail(id, nometable) {
    const urlApiEmail = './api_query/update_certificado.php';
    const formDataSend = new FormData();
    formDataSend.append('id', id);
    formDataSend.append('nomeTabela', nometable);

    try {
        // 1. Aguarda a requisição ser completada
        const response = await fetch(urlApiEmail, {
            method: 'POST',
            body: formDataSend
        });

        // 2. Verifica se a resposta HTTP foi bem-sucedida (ex: status 200)
        if (!response.ok) {
            // Se não for, lança um erro para cair no bloco catch
            throw new Error(`Erro na rede: ${response.statusText}`);
        }

        // 3. Converte a resposta do PHP (que deve ser JSON) para um objeto
        const result = await response.json();

        // 4. Verifica se a operação no backend foi bem-sucedida
        //    (supondo que seu PHP retorne { "success": true } ou { "success": false })
        if (!result.success) {
            // Se o PHP reportou um erro, lança um erro
            throw new Error(result.message || 'O servidor não conseguiu atualizar o status.');
        }

        // Se tudo deu certo, pode opcionalmente logar no console
        document.dispatchEvent(new CustomEvent('dadosAtualizados'));        
        console.log('Status atualizado com sucesso no backend.');

    } catch (error) {
        // 5. Se qualquer etapa acima falhar, exibe um pop-up de erro
        console.error("Falha ao atualizar o status:", error);
        Swal.fire({
            icon: 'error',
            title: 'Oops... Algo deu errado!',
            text: 'O e-mail foi enviado, mas não foi possível atualizar o status no sistema. Por favor, contate o suporte.',
        });
    }
}



function baixarCertificado(button) {
    const data = button.dataset;
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'certificado_dow';
    form.target = '_blank';

    for (const key in data) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = data[key];
        form.appendChild(input);
    }

    const actionInput = document.createElement('input');
    actionInput.type = 'hidden';
    actionInput.name = 'action';
    actionInput.value = 'download';
    form.appendChild(actionInput);

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

