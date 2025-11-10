<div>
    <p style="font-size: 20px; font-weight:700">Dados do organizador do grupo.
    </p>
</div>

<!-- <form id="frmcad" method="post"> -->

<div class="row">
    <div class="col-md-6 col-sm-6 col-lg-6 ">

        <label id="labelNome" class="labelObrigatorio"><strong>NOME :<span class="obrig"> *</span> <span class="inputNomepac-info infoAlerta"></span></strong></label>
        <input type="text" id="inputNome" class="form-control input-required" maxlength="100" name="nomecad" placeholder="Nome">
    </div>

    <div class="col-md-6 col-sm-6 col-lg-6 ">
        <label id="labelCpf" class="upp" for="cpf"><strong>CPF<span class="obrig"> *</span><span class="inputCpf-info infoAlerta"></span></strong></label>
        <input type="text" id="inputCpf" name="cpfcad" placeholder="CPF" class="form-control input-required" maxlength="14">
    </div>
</div>
<div class="row">

    <div class="col-md-6 col-sm-6 col-lg-6 ">
        <label id="labelEmail"><strong>E-MAIL:<span class="obrig"> *</span></strong></label>
        <input type="email" id="inputEmail" class="form-control" maxlength="100" name="emailcad" placeholder="E-mail" aria-label="mail">
    </div>

    <div class="col-md-6 col-sm-6 col-lg-6 ">
        <label id="labelTelefone"><strong>TELEFONE:<span class="obrig"> *</span></strong></label>
        <input type="text" id="inputTelefone" class="form-control" maxlength="16" name="fonecad" placeholder="Telefone" aria-label="Telefone">
    </div>

</div>

<?php

$setstr = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$code = substr(str_shuffle($setstr), 0, 6);

?>

<div class="row">
    <div style="margin: 10px 0px;" class="col-12 align-self-start upp doww">
        <div class="row align-self-start">

            <div class="col-8 upp">
                <button id="dadoslote_grupo" type="submit" class="btn btn-success">Continuar</button>
                <!-- <input id="sbmlote_one" type="submit" class="btn btn-success" value="Continuar" /> -->
                <input id="value-mod-select" name="mod_select" type="hidden">
                <input id="value-lote-select" name="lote_select" type="hidden">
                <input id="organ_grupo" name="organ_grupo" type="hidden" value="<?php echo $code ?>">

            </div>
        </div>
    </div>
</div>
<div class="carregando" style="color:green"></div>
<div class="resultadoLoading" style="color: red;"></div>
<!-- </form> -->

<hr>
<div class="selecao">
    <h2 class="compra_valor">Modalidade selecionada: <span class="mod_select resumoSpan"></span> </h2>
    <!-- <h2 class="compra_valor">Valor da compra: R$&nbsp;<span class="lote_select resumoSpan"></span> por pessoa.</h2> -->
</div>
<hr>