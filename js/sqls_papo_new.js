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
    
    if (val !== 'Individual') {

        Swal.fire({
            title: 'Cadastro Casal',
            html: `
                <form id="frmInsc_papo" method="post">      
                <input type="text" id="nome" class="swal2-input" placeholder="Nome do(a) primeiro(a) responsável">
                <input type="text" id="nome2" class="swal2-input" placeholder="Nome do(a) segundo(a) responsável">
                <input type="email" id="email" class="swal2-input" placeholder="Email">
                <input type="text" id="tele" class="swal2-input" placeholder="Telefone">
                </form>
            `,
            confirmButtonText: 'Continue&nbsp;<i class="fa fa-solid fa-arrow-right"></i>',
            confirmButtonColor: 'LightSeaGreen',
            // showCancelButton: true,
            // showConfirmButton: true,
            focusConfirm: false,
            preConfirm: () => {
                const nome = Swal.getPopup().querySelector('#nome').value;
                const nome2 = Swal.getPopup().querySelector('#nome2').value;
                const email = Swal.getPopup().querySelector('#email').value;
                const telefone = Swal.getPopup().querySelector('#tele').value;

                if (!nome || !nome2 || !email || !telefone) {
                    Swal.showValidationMessage('Preencha todos os campos!');
                }
                return {
                    nomecad: nome + ' e ' + nome2,
                    emailcad: email,
                    fonecad: telefone,
                    mod_select: modalidade
                };
            },
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    method: 'POST',
                    url: './sqls/insert_papo.php',
                    data: result.value,
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
                            console.log(result.value.emailcad);
                            enviaDados(result.value.emailcad);

                            Swal.fire({
                                position: "top",
                                icon: "success",
                                // title: "Alteração",
                                text: 'Cadastro realizado com sucesso!',
                                footer: "<img src='./assets/img/loading03.gif' style='width: 50%;'>",
                                showConfirmButton: false,
                                timer: 2000,

                                willClose: () => {
                                    window.location.href = "https://pag.ae/7_wSz64zt";
                                }
                            });

                        }

                    }

                });

            }
        });

    } else {

        Swal.fire({
            title: 'Cadastro Individual',
            html: `
            <form id="frmInsc_papo" method="post">      
            <input type="text" id="nome" class="swal2-input" placeholder="Nome">
            <input type="email" id="email" class="swal2-input" placeholder="Email">
            <input type="text" id="tele" class="swal2-input" placeholder="Telefone">
            </form>
        `,
            confirmButtonText: 'Continue&nbsp;<i class="fa fa-solid fa-arrow-right"></i>',
            confirmButtonColor: 'LightSeaGreen',
            focusConfirm: false,
            preConfirm: () => {
                const nome = Swal.getPopup().querySelector('#nome').value;
                const email = Swal.getPopup().querySelector('#email').value;
                const telefone = Swal.getPopup().querySelector('#tele').value;

                if (!nome || !email || !telefone) {
                    Swal.showValidationMessage('Preencha todos os campos!');
                }
                return {
                    nomecad: nome,
                    emailcad: email,
                    fonecad: telefone,
                    mod_select: modalidade
                };
            },
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    method: 'POST',
                    url: './sqls/insert_papo.php',
                    data: result.value,
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
                            console.log(result.value.emailcad);
                            enviaDados(result.value.emailcad);

                            Swal.fire({
                                position: "top",
                                icon: "success",
                                // title: "Alteração",
                                text: 'Cadastro realizado com sucesso!',
                                footer: "<img src='./assets/img/loading03.gif' style='width: 50%;'>",
                                showConfirmButton: false,
                                timer: 2000,

                                willClose: () => {
                                    window.location.href = "https://pag.ae/7_wSBNjCP";
                                }
                            });

                        }

                    }

                });

            }
        });

    }

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