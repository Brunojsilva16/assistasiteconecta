$(document).ready(function () {

    function validarCode() {

        const linkv = document.getElementById('inputText2').value;

        if (linkv == 'null' || linkv == '') {
            document.getElementById('labelText2').innerHTML = "<span class='text-danger'>Link Inválido</span>";
            return false;
        } else {
            document.getElementById('labelText2').innerHTML = "Digite ou cole aqui o link";
        }

        return true;
    }

    function generateRandomString(length) {
        let result = '';
        // const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        const characters = 'abcdefghijklmnopqrstuvwxyz';
        const charactersLength = characters.length;
        for ( let i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }

    $('.btn_gerar').on('click', function (e) {
        e.preventDefault();

    // const formCode = document.getElementById("btn_gerar");
    // formCode.addEventListener("submit", function (e) {
    //     e.preventDefault();

    //     const codeForm = new FormData(formCode, e.submitter);

        if (validarCode()) {

            const nome = document.getElementById('inputText1').value;
            const link = document.getElementById('inputText2').value;
            const checkcor = document.getElementById('corCheck1').checked;

            $.ajax({
                method: 'POST',
                url: './sqls/fetch_cracha_free.php',
                data: {nome: nome, link: link, checkcor: checkcor },
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
                            showConfirmButton: false,
                            html: response,
                            footer: '<button id="btn_download" class="btn btn-outline-success">Download</button>'

                        });

                        // Seletor para a div que você deseja salvar
                        const divToDownload = document.querySelector('#crachar_download');

                        // Seletor para o botão de download
                        const downloadButton = document.getElementById('btn_download');

                        downloadButton.addEventListener('click', downloadDivAsImage);

                        function downloadDivAsImage() {
                            // Crie um elemento de imagem
                            const image = document.createElement('img');

                            console.log(divToDownload);

                            // Converta a div em uma imagem usando o DOMtoImage
                            domtoimage.toPng(divToDownload)
                                .then(function (dataUrl) {
                                    // Defina o atributo 'src' da imagem
                                    image.src = dataUrl;

                                    // Crie um link para download
                                    const link = document.createElement('a');
                                    link.href = dataUrl;
                                    link.download = 'Qrcode_' + generateRandomString(6) + '.jpg';

                                    // Anexe a imagem ao link
                                    link.appendChild(image);

                                    // Simule um clique no link para iniciar o download
                                    link.click();
                                })
                                .catch(function (error) {
                                    console.error('Erro ao converter a div em imagem:', error);
                                });
                        }

                    }

                }
            });

        } else {

            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Campo obrigarótio",
                // footer: '<a href="#">Why do I have this issue?</a>'
            });
        }

    });

});