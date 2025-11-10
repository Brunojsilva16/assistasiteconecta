
$(function () {

    maskHabilita();

});

function maskHabilita() {

    // alert('tsts');


    // $('#inputCpf').mask('000.000.000-00', {
    //     onKeyPress: function (cpfcnpj, e, field, options) {
    //         const masks = ['000.000.000-000', '00.000.000/0000-00'];
    //         const mask = (cpfcnpj.length > 14) ? masks[1] : masks[0];
    //         $('#inputCpf').mask(mask, options);
    //     }
    // });
    $('.seucpf').mask('000.000.000-00');
    $('.seucep').mask('00000-000');
    $('.seuphone').mask('(00) 010000-0000');



}


// $(document).ready(function () {



// });