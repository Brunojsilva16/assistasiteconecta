// Insert dados  
function validarFormularioPre() {

    var nome = $("#nomef").val();
    var email = $("#emailf").val();
    var telefone = $("#telefonef").val();

    if (nome == 'null' || nome == '') {
        document.getElementById('labelNome').innerHTML = "<span class='text-warning'>Nome Inválido</span>";
        return false;
    } else {
        document.getElementById('labelNome').innerHTML = "Nome";
    }

    if (email == 'null' || email == '') {
        document.getElementById('labelEmail').innerHTML = "<span class='text-warning'>Email Inválido</span>";
        return false;
    } else {
        document.getElementById('labelEmail').innerHTML = "Email";
    }

    // if (telefone == 'null' || telefone == '') {
    //     document.getElementById('labelTelefone').innerHTML = "<span class='text-danger'>Telefone Inválido</span>";
    //     return false;
    // } else {
    //     document.getElementById('labelTelefone').innerHTML = "Telefone";
    // }

    validarCelular(telefone);
    // console.log(value);

    return true;
}

const formInsert = document.getElementById("frmPrecad");
formInsert.addEventListener("submit", function (e) {
    e.preventDefault();
    const insertForm = new FormData(formInsert, e.submitter);

    if (validarFormularioPre()) {


        $.ajax({
            method: 'POST',
            url: './sqls/insert_precad.php',
            data: insertForm,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                $(".carregando").html('Aguarde, processando requisição...');
                $(".resultadoLoading").html("<img src='./assets/img/loading03.gif' style='width: 100%;'>");
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
                        position: "top-end",
                        icon: "success",
                        title: "Alteração",
                        text: response.message,
                        footer: "Você está sendo redirecionado para o grupo aguarde!",
                        showConfirmButton: false,
                        timer: 3000,

                        willClose: () => {
                            window.location.href = "https://chat.whatsapp.com/GnmFlmdyR8W6qFY2IrEFE0";
                        }
                    });

                }
            }
        });

    } else {
        Swal.fire({
            icon: "error",
            // title: "Oops... ",
            text: "Verifique os campos do formulário!",
            // footer: '<a href="#">Why do I have this issue?</a>'
        });
        $(".swal2-confirm").css('background-color', '#AF2846');
    }

});