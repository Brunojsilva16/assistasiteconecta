function scrollSmoothPage(id) {
    var elmnt = document.getElementById(id);
    elmnt.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

$(".botao-sombra1").on("click", function (e) {
    e.preventDefault();

    $.post('./forms/tus-lote_dados_frm.php', function (retorna) {

        // limparCamp();
        $("#frmInsc_lote").html(retorna);

        var el = document.getElementById('teforms');
        var ellote = document.getElementById('lotes');
        var eldiv = document.getElementById('pagament1');
        el.style.display = "flex";
        eldiv.style.display = "none";
        eldiv.style.transition = "transform 0.4s ease";
        ellote.style.paddingBottom = '16px';
        //  el.setAttribute('padding-top','150px');

        $("#value-lote-select").val("127,90");
        $(".lote_select").text('127,90');

        scrollSmoothPage('teforms');
        callMaskRes();

    });

});

const formConsult = document.getElementById("frmInsc_lote");
formConsult.addEventListener("submit", function (e) {
    e.preventDefault();
    const pagForm = new FormData(formConsult, e.submitter);

    // const dataObject = Object.fromEntries(pagForm.entries());
    // console.log(dataObject);

    // const name = pagForm.get("nomecad");

    // console.log(name);

    if (validarFormulario()) {

        $.ajax({
            method: 'POST',
            url: './sqls/tus_insert.php',
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

                    $.post('./forms/tus-lote_resumov3.php', function (retorna) {

                        $("#frmInsc_lote").html(retorna);

                        enviaDados(pagForm.get('emailcad'));

                        //*oculta os dados de cadastro do participante e entra no resumo de pag

                        // *leva as informações para o resumo
                        $("#mpartipante").text(pagForm.get('nomecad'));
                        // $("#mcompra").text(pagForm.get('mod_select'));

                        var texto = document.getElementById('txtclic');
                        texto.innerHTML = "<span class='txbotaopagamento'>Pague clicando no botão abaixo:</span><br>";
                        var texto = document.getElementById('txtcartao');
                        texto.innerHTML = "      <div class='col - 12 upp'><h5 style='margin-top: 10px; opacity: 0.6;'>Em até 3x no cartão</h5></div>";

                        var botao = document.getElementById('botaopagamento');
                        botao.innerHTML = "<a href='https://pag.ae/7_GFD-pHM/button' target='_blank' title='Pagar com PagBank'><img src='//assets.pagseguro.com.br/ps-integration-assets/botoes/pagamentos/205x30-pagar-azul.gif' alt='Pague com PagBank - é rápido, grátis e seguro!' /></a>";

                        // valor enviado para div resumo
                        var x = 'R$ 127,90';
                        // var vall = x.replaceAll(",", ".");
                        // let valorfx = parseInt(vall);
                        $("#value_resumo").val(x);

                        // $("#id_resumo").val(response.id_participante);
                        // $("#cat_compra").val(pagForm.get('mod_select'));

                        Swal.fire({
                            position: "top",
                            showConfirmButton: false,
                            timer: 2000,
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

function validarFormulario() {

    var nome = $("#inputNome").val();
    var cpf = $("#inputCpf").val();
    var email = $("#inputEmail").val();
    var telefone = $("#inputTelefone").val();

    if (nome == 'null' || nome == '') {
        document.getElementById('labelNome').innerHTML = "<strong><span class='text-danger'>Nome Inválido</span></strong>";
        return false;
    } else {
        document.getElementById('labelNome').innerHTML = "<strong><strong class='frmulario'>NOME:<span class='obrig'> *</span></strong>";
    }

    if (cpf == 'null' || cpf == '') {
        document.getElementById('labelCpf').innerHTML = "<strong><span class='text-danger'>Cpf Inválido</span></strong>";
        return false;
    } else {
        document.getElementById('labelCpf').innerHTML = "<strong class='frmulario'>CPF:<span class='obrig'> *</span></strong>";
    }

    if (email == 'null' || email == '') {
        document.getElementById('labelEmail').innerHTML = "<strong><span class='text-danger'>Email Inválido</span></strong>";
        return false;
    } else {
        document.getElementById('labelEmail').innerHTML = "<strong class='frmulario'>EMAIL:<span class='obrig'> *</span></strong>";
    }

    if (telefone == 'null' || telefone == '') {
        document.getElementById('labelTelefone').innerHTML = "<strong><span class='text-danger'>Telefone Inválido</span></strong>";
        return false;
    } else {
        document.getElementById('labelTelefone').innerHTML = "<strong class='frmulario'>TELEFONE:<span class='obrig'> *</span></strong>";
    }

    // validarCelular(telefone);
    return true;
}


function enviaDados(email) {
    var dados = {
        email: email
    }
    $.post('./includes/output_workshopv3.php', dados, function () {
        return true;
    });
}