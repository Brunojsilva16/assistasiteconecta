function scrollSmoothPage(id) {
    var elmnt = document.getElementById(id);
    elmnt.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

const formConsult = document.getElementById("frmInsc_lote");
formConsult.addEventListener("submit", function (e) {
    e.preventDefault();

    if (validarFormulario()) {

        inserDados();


    } else {
        Swal.fire({
            icon: "error",
            text: "Verifique os campos do formulário!",
        });
        $(".swal2-confirm").css('background-color', '#AF2846');
    }

});


async function inserDados() {
    const caminhoAPI = './api_query/insert_ciab.php';

    const formData = new FormData();
    formData.append('nome', document.getElementById('inputNome').value);
    formData.append('email', document.getElementById('inputEmail').value);
    formData.append('whatsapp', document.getElementById('inputTelefone').value);

    try {
        const response = await fetch(caminhoAPI, {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error(`Erro na requisição: ${response.status}`);
        }

        const resultado = await response.json();

        // NOVO: Verifica se o cadastro já existe
        if (resultado && resultado.exists === true) {
            Swal.fire({
                icon: "warning",
                title: "Cadastro Duplicado",
                text: resultado.message,
            });
            $(".swal2-confirm").css('background-color', '#AF2846');

            // Verifica se o cadastro foi realizado com sucesso
        } else if (resultado && resultado.success === true) {
            Swal.fire({
                icon: "success",
                position: "top",
                text: resultado.message,
                showConfirmButton: false,
                timer: 2500,
                willClose: () => {
                    document.querySelector("frmInsc_lote")?.reset(); // limpa o formulário
                    window.location.href = "https://www.assistaconecta.com.br";
                }

            });

            // Trata outros tipos de erros
        } else {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: resultado.message || "Ocorreu um erro inesperado.",
            });
            $(".swal2-confirm").css('background-color', '#AF2846');
        }


    } catch (error) {
        console.error("Falha ao Cadastrar:", error);
        Swal.fire({
            icon: "error",
            title: "Erro de Comunicação",
            text: "Não foi possível se conectar ao servidor. Tente novamente mais tarde.",
        });
        return false;
    }
}

function validarFormulario() {

    var nome = $("#inputNome").val();
    var email = $("#inputEmail").val();
    var telefone = $("#inputTelefone").val();

    if (nome == 'null' || nome == '') {
        document.getElementById('labelNome').innerHTML = "<strong><span class='text-danger'>Nome Inválido</span></strong>";
        return false;
    } else {
        document.getElementById('labelNome').innerHTML = "<strong><strong class='frmulario'>NOME:<span class='obrig'> *</span></strong>";
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