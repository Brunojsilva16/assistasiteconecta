(function (win, doc) {
    'use script';

    if (doc.querySelector('#formCard')) {

        let formCard = doc.querySelector('#formCard');
        formCard.addEventListener('submit', (e) => {
            e.preventDefault();

            // let CardX = doc.querySelector('input[type=radio][name=cardValor]:checked');
            // let x = CardX.value;
            // let cardValor = parseInt(x);

            let cardIdvalor = doc.querySelector('#pag_idpartipante');
            let cardIdpart = cardIdvalor.value;

            let valorCodparc = doc.querySelector('#pag_codpc');
            let cardCodparc = valorCodparc.value;

            let valorCat = doc.querySelector('#cat_catcomp');
            let cardCatg = valorCat.value;

            let cardNumber = doc.querySelector('#cardNumber');
            let nubCard = cardNumber.value.replaceAll(" ", "");
            let cardN = parseInt(nubCard);

            let cardMonth = doc.querySelector('#cardMonth');
            let monthExp = cardMonth.value;

            let cardYear = doc.querySelector('#cardYear');
            let yearExp = cardYear.value;

            let cardCvv = doc.querySelector('#cardCvv');
            let codeSeg = cardCvv.value;

            let cardParc = doc.querySelector('#cardNparcelas');
            let cardValor = 100 * cardParc.value;

            let cardParcelas = doc.querySelector('#cat_nParcela');
            let caN = cardParcelas.value;
            let cadNparc = parseInt(caN);

            let holderVal = doc.querySelector('#cardName');
            let cardName = holderVal.value;

            let cardNcpf = doc.querySelector('#cardNcpf');
            let cpfCard = cardNcpf.value.replaceAll(" ", "");

            let cardNemail = doc.querySelector('#cardNemail');
            let cardMail = cardNemail.value;

            let cardd = doc.querySelector('#cadddd');
            let cardddd = cardd.value;

            let cadfo = doc.querySelector('#cadfone');
            let cadfone = cadfo.value.replaceAll(" ", "");

            let cardCep = doc.querySelector('#cardCep');
            let cepNum = cardCep.value;

            let cardRua = doc.querySelector('#cardRua');
            let valorRua = cardRua.value;

            let cardNum = doc.querySelector('#cardNum');
            let valorNum = cardNum.value;

            let cardComp = doc.querySelector('#cardComp');
            let valorComp = cardComp.value;

            let cardBa = doc.querySelector('#cardBairro');
            let valorBairro = cardBa.value;

            let cardCi = doc.querySelector('#cardCidade');
            let valorCidade = cardCi.value;

            let cardEst = doc.querySelector('#cardEstado');
            let valorEstado = cardEst.value;

            let card = PagSeguro.encryptCard({
                publicKey: myResponse,
                holder: cardName,
                number: cardN,
                expMonth: monthExp,
                expYear: yearExp,
                securityCode: codeSeg
            });

            let encryptedC = card.encryptedCard;

            if (cardNumber.value == '' || null) {
                alert("Digite o número do cartão");
                cardNumber.focus();
                return false;

            } else if (cardNumber.value.length < 19) {
                alert("Digitos do cartão incorretos");
                cardNumber.focus();
                return false;

            } else if (cardName.value == '' || null) {
                alert("Digite um nome impresso no cartão");
                cardName.focus();
                return false;

            } else if (cardMonth.value == '' || null) {
                alert("Selecione o mês de vencimento");
                cardMonth.focus();
                return false;

            } else if (cardYear.value == '' || null) {
                alert("Selecione o ano de vencimento");
                cardYear.focus();
                return false;

            } else if (cardCvv.value == '' || null) {
                alert("Digite o código de segurança do cartão");
                cardCvv.focus();
                return false;
            } else if (cardCvv.value.length < 3) {
                alert("Digitos do CVV incorretos");
                cardCvv.focus();
                return false;

            } else if (cardNcpf.value == '' || null) {
                alert("Digite seu cpf");
                cardNcpf.focus();
                return false;
            } else if (cardNcpf.value.length < 14) {
                alert("Digitos do cpf incorretos");
                cardNcpf.focus();
                return false;

            } else if (cardNemail.value == '' || null) {
                alert("Digite seu email");
                cardNemail.focus();
                return false;

            } else {

                $.ajax({
                    method: "POST",
                    url: "./pagseg/payController.php",
                    data: {
                        encrypted: encryptedC,
                        cardCvv: codeSeg,
                        cardName: cardName,
                        cardNcpf: cpfCard,
                        cardValor: cardValor,
                        parcValor: cadNparc,
                        cardNemail: cardMail,
                        cardddd: cardddd,
                        cadfone: cadfone,
                        idparc: cardIdpart,
                        cardCatg: cardCatg,
                        cdoparc: cardCodparc,
                        cepNum: cepNum,
                        valorrua: valorRua,
                        valorNum: valorNum,
                        valorcomp: valorComp,
                        valorBairro: valorBairro,
                        valorCidade: valorCidade,
                        valorEstado: valorEstado
                    },
                    beforeSend: function () {
                        $("#carregando").html('Processando pagamento...');
                        $("#resultado").html("<img src='./assets/img/loading03.gif' style='width: 100%;'>");
                    },

                    success: function (response) {
                        if (response.error) {
                            $("#resultado").html(response.error);
                            $("#carregando").html('');
                        } else {
                            $("#carregando").html('');
                            $("#resultado").html('');
                            $("#resultado").html(response);
                            // getVerifica();
                        }
                    }

                });
                // formCard.submit();
            }

        });
    }
})(window, document);


var myResponse;
function listarMarcas(callback) {
    $.ajax({
        type: "POST",
        url: "./pagseg/keyPublic.php",
        data: { keycontroll: 'valor' },
        dataType: "json",
        success: function (res) {
            callback(res);
        },
        error: function (res) {
            callback(res);
        }
    });
}
// usar
listarMarcas(result => {
    myResponse = result.valorKey;
});

function onchangeSelec(val) {
    // const selectElem = document.getElementById("cardNparcelas");
    const index = val.selectedIndex;
    var parcx = index + 1;
    let valorx = parseInt(parcx);
    $("#cat_nParcela").val(valorx);
    // console.log(index + 1);
}


// function getVerifica() {
//     $.ajax({
//         method: 'POST',
//         url: './includes/verifica.php',
//         // data: { chave: id },
//         dataType: 'json',
//         success: function (response) {

//             if (response.error) {
//                 console.log(response.error);
//                 $('#resultado').html(response.message);
//             }
//             else {
//                 console.log(response.data);
//                 if (response.data.status_pag != null) {
//                     redirectPage(response.data.status_pag);
//                 }
//             }
//         }
//     });
// };

// function getConsult() {
//     $.ajax({
//         method: 'POST',
//         url: '../includes/verifica.php',
//         // data: { chave: id },
//         dataType: 'json',
//         success: function (response) {

//             var venDate = response.data.data_pag;
//             var curDate = new Date(venDate);


//             if (response.error) {
//                 console.log(response.error);
//                 $('#resultado').html(response.message);
//             }
//             else {
//                 console.log(response.data);

//                 if (response.data.status_pag != null) {

//                     $('#email').html(response.data.email_pag);
//                     $('#modalidade').html(response.data.categoria_pag);
//                     $('#datacadastro').text(data_hora(curDate));
//                 }
//             }
//         }
//     });
// };

