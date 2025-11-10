function validarFormGrupo() {

    var nome = $("#inputNome").val();
    var cpf = $("#inputCpf").val();
    var email = $("#inputEmail").val();
    var telefone = $("#inputTelefone").val();

    if (nome == 'null' || nome == '') {
        document.getElementById('labelNome').innerHTML = "<span class='text-danger'>Nome Inválido</span>";
        return false;
    } else {
        document.getElementById('labelNome').innerHTML = "Nome";
    }

    if (cpf == 'null' || cpf == '') {
        document.getElementById('labelCpf').innerHTML = "<span class='text-danger'>Cpf Inválido</span>";
        return false;
    } else {
        document.getElementById('labelCpf').innerHTML = "Cpf";
    }

    if (email == 'null' || email == '') {
        document.getElementById('labelEmail').innerHTML = "<span class='text-danger'>Email Inválido</span>";
        return false;
    } else {
        document.getElementById('labelEmail').innerHTML = "Email";
    }

    if (telefone == 'null' || telefone == '') {
        document.getElementById('labelTelefone').innerHTML = "<span class='text-danger'>Telefone Inválido</span>";
        return false;
    } else {
        document.getElementById('labelTelefone').innerHTML = "Telefone";
    }

    return true;
}

const formGrupo = document.getElementById("formGrupo");
formGrupo.addEventListener("submit", function (e) {
    e.preventDefault();
    const grupoForm = new FormData(formGrupo, e.submitter);

    if (validarFormGrupo()) {

        $.ajax({
            method: 'POST',
            url: './sqls/insert_organ_grupo.php',
            data: grupoForm,
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
                        // title: "Alteração",
                        text: response.message,
                        footer: "Você será direcionado para o Whatsapp do nosso time de atendimento, aguarde o contato que finalizaremos sua compra.",
                        showConfirmButton: false,
                        timer: 6500,

                        willClose: () => {
                            const elementfour = document.getElementById("formGrupo");
                            elementfour.innerText = "";
                            window.location.href = "https://api.whatsapp.com/send?phone=5581997913554&text=Ol%C3%A1%20Time%20Assista%20Conecta!%0AGostaria%20de%20dar%20seguimento%20a%20minha%20inscri%C3%A7%C3%A3o%20na%20modalidade%20GRUPO%2C%20podem%20me%20ajudar%3F";

                        }
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