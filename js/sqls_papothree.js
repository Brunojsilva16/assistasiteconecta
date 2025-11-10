function scrollSmoothPage(id) {
    var elmnt = document.getElementById(id);
    elmnt.scrollIntoView({ behavior: 'smooth', block: 'start' });
}


document.getElementById('btnIndividual').addEventListener('click', () => {
    cadastroPapo('Individual');
});

document.getElementById('btnCasal').addEventListener('click', () => {
    cadastroPapo('Casal');
});



function cadastroPapo(val) {
    const modalidade = val;
    const mascaraTelefone = '(99) 99999-9999';


    if (val !== 'Individual') {

        Swal.fire({

            title: 'Cadastro Individual',
            html: `
            <form id="frmInsc_papo" method="post">
            <input type="text" id="nome" class="swal2-input" placeholder="Nome do(a) primeiro(a) responsável" required>
            <input type="text" id="nometwo" class="swal2-input" placeholder="Nome do(a) segundo(a) responsável" required>
            <input type="email" id="email" class="swal2-input" placeholder="Email" required>
            <input type="text" id="tele" class="swal2-input" placeholder="${mascaraTelefone}" required>
            </form>`,
            confirmButtonText: 'Continue&nbsp;<i class="fa fa-solid fa-arrow-right"></i>',
            confirmButtonColor: 'LightSeaGreen',
            focusConfirm: false,
            didOpen: (popup) => {
                // Aplica a máscara ao campo de telefone quando o modal abrir
                const telefoneInput = popup.querySelector('#tele'); // É mais seguro buscar dentro do 'popup'
                if (telefoneInput) {
                    VMasker(telefoneInput).maskPattern(mascaraTelefone);
                }
            },
            preConfirm: () => {
                const nome = Swal.getPopup().querySelector('#nome').value;
                const nometwo = Swal.getPopup().querySelector('#nometwo').value;
                const email = Swal.getPopup().querySelector('#email').value;
                const telefone = Swal.getPopup().querySelector('#tele').value;

                if (!nome || !nometwo || !email || !telefone) {
                    Swal.showValidationMessage('Preencha todos os campos!');
                    return false; // Impede a confirmação explicitamente
                }

                // Você pode adicionar outras validações aqui, por exemplo, para o formato do email:
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    Swal.showValidationMessage('Por favor, insira um endereço de e-mail válido.');
                    return false; // Impede a confirmação
                }

                // Se todas as validações passarem:
                return {
                    nomecad: nome + ' e ' + nometwo,
                    emailcad: email,
                    fonecad: telefone,
                    mod_select: modalidade // Certifique-se que 'modalidade' está definida aqui
                };
            },

        }).then((result) => {

            if (result.isConfirmed) {

                insertAjax(result.value, "https://pag.ae/7_t9ur916");

            }
        });

    } else {

        Swal.fire({

            title: 'Cadastro Individual',
            html: `
            <form id="frmInsc_papo" method="post">
            <input type="text" id="nome" class="swal2-input" placeholder="Nome" required>
            <input type="email" id="email" class="swal2-input" placeholder="Email" required>
            <input type="text" id="tele" class="swal2-input" placeholder="${mascaraTelefone}" required>
            </form>`,
            confirmButtonText: 'Continue&nbsp;<i class="fa fa-solid fa-arrow-right"></i>',
            confirmButtonColor: 'LightSeaGreen',
            focusConfirm: false,
                        didOpen: (popup) => {
                // Aplica a máscara ao campo de telefone quando o modal abrir
                const telefoneInput = popup.querySelector('#tele'); // É mais seguro buscar dentro do 'popup'
                if (telefoneInput) {
                    VMasker(telefoneInput).maskPattern(mascaraTelefone);
                }
            },
            preConfirm: () => {
                const nome = Swal.getPopup().querySelector('#nome').value;
                const email = Swal.getPopup().querySelector('#email').value;
                const telefone = Swal.getPopup().querySelector('#tele').value;

                if (!nome || !email || !telefone) {
                    Swal.showValidationMessage('Preencha todos os campos!');
                    return false; // Impede a confirmação explicitamente
                }

                // Você pode adicionar outras validações aqui, por exemplo, para o formato do email:
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    Swal.showValidationMessage('Por favor, insira um endereço de e-mail válido.');
                    return false; // Impede a confirmação
                }

                // Se todas as validações passarem:
                return {
                    nomecad: nome,
                    emailcad: email,
                    fonecad: telefone,
                    mod_select: modalidade // Certifique-se que 'modalidade' está definida aqui
                };
            },

        }).then((result) => {
            if (result.isConfirmed) {

                insertAjax(result.value, "https://pag.ae/7_t9tQ5X2");

            }
        });

    }

}

function insertAjax(dados = [], pag) {

    console.log(dados);

    $.ajax({
        method: 'POST',
        url: './sqls/insert_papo.php',
        data: dados,
        dataType: 'json',
        beforeSend: function () {

            $(".carregando").html('Aguarde, processando requisição...');
            $(".resultadoLoading").html("<img src='./assets/img/loading03.gif' style='width: 50%;'>");
        },
        success: function (response) {
            $(".carregando").html('');
            $(".resultadoLoading").html('');

            if (response.error) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: response.message,
                    // footer: '<a href="#">Why do I have this issue?</a>'
                });
            }
            else {
                console.log(dados.emailcad);
                enviaDados(dados.emailcad);

                Swal.fire({
                    position: "top",
                    icon: "success",
                    // title: "Alteração",
                    text: 'Cadastro realizado! Você está sendo direcionado para página de pagamento.',
                    footer: "<img src='./assets/img/loading03.gif' style='width: 50%;'>",
                    showConfirmButton: false,
                    timer: 4000,

                    willClose: () => {
                        window.location.href = pag;
                    }
                });

            }

        }

    });

}

function enviaDados(email) {
    var dados = {
        email: email
    }
    $.post('./includes/output_papo.php', dados, function () {
        return true;
    });
}

function escolhido(radioname) {
    var res;
    const items = document.getElementsByName(radioname);
    for (var i = 0; i < items.length; i++) {
        if (items[i].checked) {
            res = items[i].value
            break;
        } else {
            res = false;
        }
    }
    return res;
}

function verificar(nome) {
    const res = escolhido(nome);

    if (res) {
        return res;
    } else {
        return false;
    }
}