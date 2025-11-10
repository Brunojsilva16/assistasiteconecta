function scrollSmoothPage(id) {
    var elmnt = document.getElementById(id);
    elmnt.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

$(".btn-modalidade_zero").on("click", function (e) {
    e.preventDefault();

    const form_escolha = verificar('loteone_radio');

    switch (form_escolha) {

        case 'Profissional':

            $.post('./forms/lote_dados_frm.php', function (retorna) {
                const elementone = document.getElementById("formGrupo");
                elementone.innerText = "";
                $("#frmInsc_lote").html(retorna);

                document.getElementById("pagamento").style.display = "flex";
                document.getElementById("docUpload").style.display = "none";

                $("#value-mod-select").val(form_escolha);
                $("#value-lote-select").val("387,00");
                $(".mod_select").text(form_escolha);
                $(".lote_select").text('387.00');

                scrollSmoothPage('pagamento');
                callMaskRes();
            });
            break;

        case 'Parceiro':            // element.remove();
            $.post('./forms/lote_dados_frm.php', function (retorna) {
                const elementtwo = document.getElementById("formGrupo");
                elementtwo.innerText = "";
                $("#frmInsc_lote").html(retorna);

                document.getElementById("pagamento").style.display = "flex";
                document.getElementById("docUpload").style.display = "flex";

                $("#value-mod-select").val(form_escolha);
                $("#value-lote-select").val('309,60');
                $(".mod_select").text(form_escolha);
                $(".lote_select").text('309.60');

                scrollSmoothPage('pagamento');
                callMaskRes();
            });
            break;

        case 'Estudante':            // element.remove();
            $.post('./forms/lote_dados_frm.php', function (retorna) {
                const elementthree = document.getElementById("formGrupo");
                elementthree.innerText = "";
                $("#frmInsc_lote").html(retorna);

                document.getElementById("pagamento").style.display = "flex";
                document.getElementById("docUpload").style.display = "flex";

                $("#value-mod-select").val(form_escolha);
                $("#value-lote-select").val('290,25');
                $(".mod_select").text(form_escolha);
                $(".lote_select").text('290.25');

                scrollSmoothPage('pagamento');
                callMaskRes();
            });
            break;

        case 'Grupo':            // element.remove();
            $.post('./forms/lote_dados_grupo.php', function (retorna) {
                const elementfour = document.getElementById("frmInsc_lote");
                elementfour.innerText = "";
                $("#formGrupo").html(retorna);

                document.getElementById("pagamento").style.display = "flex";

                $("#value-mod-select").val(form_escolha);
                $("#value-lote-select").val('348,30');
                $(".mod_select").text(form_escolha);
                $(".lote_select").text('348.30');

                scrollSmoothPage('pagamento');
                callMaskRes();

            });
            break;

        default:
            $("#frmInsc_lote").html('');
            scrollSmoothPage('inicio');
            Swal.fire({
                icon: "error",
                text: 'Você precisa selecione uma modalidade',
            });
            break;
    }

});

const formConsult = document.getElementById("frmInsc_lote");
formConsult.addEventListener("submit", function (e) {
    e.preventDefault();
    const pagForm = new FormData(formConsult, e.submitter);

    var valid = false;

    var nome = $("#inputNome").val();
    var cpf = $("#inputCpf").val();
    var email = $("#inputEmail").val();
    var telefone = $("#inputTelefone").val();

    if (nome == 'null' || nome == '') {
        valid = false;
        document.getElementById('labelNome').innerHTML = "<span class='text-danger'>Nome Inválido</span>";
    } else {
        valid = true;
        document.getElementById('labelNome').innerHTML = "Nome";
    }

    if (cpf == 'null' || cpf == '') {
        valid = false;
        document.getElementById('labelCpf').innerHTML = "<span class='text-danger'>Cpf Inválido</span>";
    } else {
        valid = true;
        document.getElementById('labelCpf').innerHTML = "Cpf";
    }

    if (email == 'null' || email == '') {
        valid = false;
        document.getElementById('labelEmail').innerHTML = "<span class='text-danger'>Email Inválido</span>";
    } else {
        valid = true;
        document.getElementById('labelEmail').innerHTML = "Email";
    }

    if (telefone == 'null' || telefone == '') {
        valid = false;
        document.getElementById('labelTelefone').innerHTML = "<span class='text-danger'>Telefone Inválido</span>";
    } else {
        valid = true;
        document.getElementById('labelTelefone').innerHTML = "Telefone";
    }

    if (valid) {

        $.ajax({
            method: 'POST',
            url: './sqls/insert_mod.php',
            data: pagForm,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {

                $(".carregando").html('Aguarde, processando requisição...');
                $(".resultadoLoading").html("<img src='./assets/img/loading03.gif' style='width: 50%;'>");
            },
            success: function (response) {
                $(".carregando").html('');
                $(".resultadoLoading").html('');

                if (response.error) {
                    // showAlert('error', response.message);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: response.message,
                        // footer: '<a href="#">Why do I have this issue?</a>'
                    });
                }
                else {

                    $.post('./forms/lote_resumo.php', function (retorna) {

                        enviaDados(pagForm.get('emailcad'));

                        $("#cardresForm").html(retorna);
                        //*oculta os dados de cadastro do participante e entra no resumo de pag
                        const elementlote = document.getElementById("frmInsc_lote");
                        elementlote.innerText = "";
                        const elementcont = document.getElementById("inputt");
                        elementcont.innerText = "";
                        document.getElementById("contorno").style.display = "none";

                        // *leva as informações para o resumo
                        $("#mpartipante").text(pagForm.get('nomecad'));
                        $("#mcompra").text(pagForm.get('mod_select'));
                        $("#vcompra").text(pagForm.get('lote_select'));

                        switch (pagForm.get('mod_select')) {

                            case 'Profissional':

                                var botao = document.getElementById('botaopagamento');
                                botao.innerHTML = "<a href='https://pag.ae/7_7q8X463/button' target='_blank' title='Pagar com PagBank'><img src='//assets.pagseguro.com.br/ps-integration-assets/botoes/pagamentos/205x30-pagar.gif' alt='Pague com PagBank - é rápido, grátis e seguro!'/></a>";
                                break;

                            case 'Parceiro':

                                var botao = document.getElementById('botaopagamento');
                                botao.innerHTML = "<a href='https://pag.ae/7_7y8_msJ/button' target='_blank' title='Pagar com PagBank'><img src='//assets.pagseguro.com.br/ps-integration-assets/botoes/pagamentos/205x30-pagar.gif' alt='Pague com PagBank - é rápido, grátis e seguro!'/></a>";
                                break;

                            case 'Estudante':

                                var botao = document.getElementById('botaopagamento');
                                botao.innerHTML = "<a href='https://pag.ae/7_7ybhHS9/button' target='_blank' title='Pagar com PagBank'><img src='//assets.pagseguro.com.br/ps-integration-assets/botoes/pagamentos/205x30-pagar.gif' alt='Pague com PagBank - é rápido, grátis e seguro!'/></a>";
                                break;
                        }

                        // valor enviado para div resumo
                        var x = pagForm.get('lote_select');
                        var vall = x.replaceAll(",", ".");
                        let valorfx = parseInt(vall);
                        $("#value_resumo").val(valorfx);

                        $("#id_resumo").val(response.id_participante);
                        $("#cat_compra").val(pagForm.get('mod_select'));

                        Swal.fire({
                            position: "top",
                            showConfirmButton: false,
                            timer: 2500,
                            footer: "<p>Aguarde, processando requisição...</P><br><img src='./assets/img/loading03.gif' style='width: 50%;'>"
                        });

                    });
                }
            }
        });

    } else {
        Swal.fire({
            icon: "error",
            text: "Verifique os campos do formulário!",
        });
        $(".swal2-confirm").css('background-color', '#AF2846');
    }

});

function enviaDados(email) {
    var dados = {
        email: email
    }
    $.post('./includes/output.php', dados, function () {
        return true;
    });
}

$(document).on('click', '#botCupom', function () {

    var compra = document.getElementById('value_resumo').value;
    var cupomparc = document.getElementById('cupomParc').value;
    var id_cad = document.getElementById('id_resumo').value;
    // modalidade da compra swit
    var mcompra = document.getElementById('mcompra').innerHTML;

    $.ajax({
        method: 'POST',
        url: './sqls/fetch_codigo.php',
        data: { cupompc: cupomparc },
        dataType: 'json',

        success: function (response) {
            if (response.error) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: response.message,
                    // footer: '<a href="#">Why do I have this issue?</a>'
                });
            }
            else {

                let cupom = response.data.porcent_cod;
                // console.log(response.data.porcent_cod + ' porcentgem');
                // let id = response;
                // let compra = response.res.id_cod;

                var valor = (compra * cupom);
                // console.log(compra + " compra");
                // console.log(valor + " Valor");

                var valorSoma = compra - valor;
                // console.log(valorSoma + " valor soma");

                var valorString = valorSoma.toFixed(2);
                console.log(valorString + " Valor string")

                var vUpdate = valorString.replaceAll(".", ",");
                console.log(vUpdate  + ' update');

                // var valll = valorString.replaceAll(".", "");
                // console.log(valll + " Valll")

                // let valorFinal = parseInt(valll);
                // console.log(valorFinal + " Valor final ")

                // $("#value_resumo").val(valorFinal);
                $("#vcompra").text(vUpdate);
                $("#cod_parceiro").val(cupomparc);
                $("#vcodigo").text('Código aplicado de 5%');

                $.ajax({
                    method: 'POST',
                    url: './sqls/update_mod.php',
                    data: {
                        codparceiro: cupomparc,
                        vresumo: vUpdate,
                        idresumo: id_cad
                    },
                    dataType: 'json',

                    success: function (response) {
                        if (response.error) {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: response.message,
                                // footer: '<a href="#">Why do I have this issue?</a>'
                            });
                        }
                        else {

                            Swal.fire({
                                position: "top",
                                icon: "success",
                                // title: "Sucesso!",
                                text: "Novo valor adicionado a sua compra!",
                                showConfirmButton: false,
                                timer: 2000
                            });

                        }
                    }
                });

                switch (mcompra) {

                    case 'Profissional':

                        var botaodesc = document.getElementById('botaopagamento');
                        botaodesc.innerHTML = "<a href='https://pag.ae/7_7y8hfHQ/button' target='_blank' title='Pagar com PagBank'><img src='//assets.pagseguro.com.br/ps-integration-assets/botoes/pagamentos/205x30-pagar-laranja.gif' alt='Pague com PagBank - é rápido, grátis e seguro!' /></a>";
                        break;

                    case 'Parceiro':

                        var botaodesc = document.getElementById('botaopagamento');
                        botaodesc.innerHTML = "<a href='https://pag.ae/7_7yatVsK/button' target='_blank' title='Pagar com PagBank'><img src='//assets.pagseguro.com.br/ps-integration-assets/botoes/pagamentos/205x30-pagar-laranja.gif' alt='Pague com PagBank - é rápido, grátis e seguro!'/></a>";
                        break;

                    case 'Estudante':

                        var botaodesc = document.getElementById('botaopagamento');
                        botaodesc.innerHTML = "<a href='https://pag.ae/7_7yc6VcQ/button' target='_blank' title='Pagar com PagBank'><img src='//assets.pagseguro.com.br/ps-integration-assets/botoes/pagamentos/205x30-pagar-laranja.gif' alt='Pague com PagBank - é rápido, grátis e seguro!'/></a>";
                        break;
                }


            }
        }
    });

});

$(document).on('click', '#resumolote_one', function () {

    var id_part = $("#id_resumo").val();
    var codigo_parc = $("#cod_parceiro").val();
    var categoria = $("#cat_compra").val();
    var val = $("#value_resumo").val();
    var valll = val.replaceAll(".", "");
    let valorFinal = parseInt(valll);

    $.post('./forms/form_pag.php', function (retorna) {
        //Subtitui o valor no seletor id="conteudo"
        $("#formCard").html(retorna);
        callMaskPag();

        $("#pag_idpartipante").val(id_part);
        $("#pag_codpc").val(codigo_parc);
        $("#cat_catcomp").val(categoria);
    });

    $.ajax({
        type: "POST",
        data: { valor: valorFinal },
        url: "./pagseg/parcelas.php",
        success: function (resp) {
            // console.log(resp);
            $("#cardNparcelas").html(resp);
        }
    });

});

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