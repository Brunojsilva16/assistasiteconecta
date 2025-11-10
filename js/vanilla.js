function inputHandler(masks, max, event) {
    var c = event.target;
    var v = c.value.replace(/\D/g, '');
    var m = c.value.length > max ? 1 : 0;
    VMasker(c).unMask();
    VMasker(c).maskPattern(masks[m]);
    c.value = VMasker.toPattern(v, masks[m]);
}

function callMaskRes() {
    var telMask = ['(99) 99999-9999'];
    var tel = document.querySelector('input[name="fonecad"]');
    VMasker(tel).maskPattern(telMask[0]);
    tel.addEventListener('input', inputHandler.bind(undefined, telMask, 16), false);

    var docMask = ['999.999.999-99'];
    var doc = document.querySelector('input[name="cpfcad"]');
    VMasker(doc).maskPattern(docMask[0]);
    doc.addEventListener('input', inputHandler.bind(undefined, docMask, 14), false);
}

function callMaskPag() {
    var cardMask = ['9999 9999 9999 9999'];
    var cad = document.querySelector('input[name="cardNumber"]');
    VMasker(cad).maskPattern(cardMask[0]);
    cad.addEventListener('input', inputHandler.bind(undefined, cardMask, 19), false);

    var ccpfMask = ['999 999 999 99'];
    var ccad = document.querySelector('input[name="cardNcpf"]');
    VMasker(ccad).maskPattern(ccpfMask[0]);
    ccad.addEventListener('input', inputHandler.bind(undefined, ccpfMask, 14), false);

    var foneMask = ['99999 9999'];
    var cfone = document.querySelector('input[name="cadfone"]');
    VMasker(cfone).maskPattern(foneMask[0]);
    cfone.addEventListener('input', inputHandler.bind(undefined, foneMask, 10), false);

    var dddMask = ['99'];
    var cddd = document.querySelector('input[name="cadddd"]');
    VMasker(cddd).maskPattern(dddMask[0]);
    cddd.addEventListener('input', inputHandler.bind(undefined, dddMask, 2), false);
}