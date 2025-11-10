<div>
    <p style="font-size: 20px; font-weight:700">Dados do participante</p>
</div>

<!-- <form id="frmcad" method="post"> -->

<!-- <form id="frmInsc_lote" method="post"> -->

    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12 ">

            <label id="labelNome" class="labelObrigatorio"><strong class="frmulario">NOME :<span class="obrig"> *</span> <span class="inputNomepac-info infoAlerta"></span></strong></label>
            <input type="text" id="inputNome" class="form-control input-required" maxlength="100" name="nomecad" placeholder="Nome">
        </div>

        <div class="col-md-12 col-sm-12 col-lg-12 ">
            <label id="labelCpf" class="upp" for="cpf"><strong class="frmulario">CPF<span class="obrig"> *</span><span class="inputCpf-info infoAlerta"></span></strong></label>
            <input type="text" id="inputCpf" name="cpfcad" placeholder="CPF" class="form-control input-required" maxlength="14">
        </div>
    </div>
    <div class="row">

        <div class="col-md-12 col-sm-12 col-lg-12 ">
            <label id="labelEmail"><strong class="frmulario">E-MAIL:<span class="obrig"> *</span></strong></label>
            <input type="email" id="inputEmail" class="form-control" maxlength="100" name="emailcad" placeholder="E-mail" aria-label="mail">
        </div>

        <div class="col-md-12 col-sm-12 col-lg-12 ">
            <label id="labelTelefone"><strong class="frmulario">TELEFONE:<span class="obrig"> *</span></strong></label>
            <input type="text" id="inputTelefone" class="form-control" minlength="15" maxlength="15" name="fonecad" placeholder="Telefone" aria-label="Telefone">
        </div>

    </div>
    <div id="tipCracha" class="row">
        <div class="col-md-12 col-sm-12 col-lg-12 ">
            <label id="labelCracha" class="labelObrigatorio"><strong class="frmulario">NOME PARA USO NO CRACHÁ:<span class="obrig"> *</span> <span class="inputNomepac-info infoAlerta"></span></strong></label>
            <input type="text" id="inputNomeCracha" class="form-control input-required" maxlength="100" name="nomecracha" placeholder="Nome Crachá">
        </div>
    </div>

    <div id="docUpload">
        <label class="form-label mtopBut10"><strong>Selecione um comprovante</strong>
            <div class="file-upload">
                <input type="file" id="imagefile" name="docfile" class="image" accept=".jpg, .jpeg, .png, .pdf">
                <label for="imagefile" class="file-upload-label">
                    <i class="fas fa-upload"></i> Escolher Arquivo
                </label>
                <span id="file-name" class="file-name-display text-secondary">Nenhum arquivo selecionado</span>
            </div>
        </label>
    </div>



    <div class="row">
        <div style="margin: 10px 0px;" class="col-12 align-self-start upp doww">
            <div class="row align-self-start">

                <div class="col-8 upp">
                    <!-- <input id="sbmlote_one" type="submit" class="btn btn-success" value="Continuar" /> -->
                    <input id="value-mod-select" name="mod_select" type="hidden">
                    <input id="value-lote-select" name="lote_select" type="hidden">
                    <button id="dadoslote_one" type="submit" class="tebtn btn btn-success">Continuar <i class="fas fa-solid fa-arrow-right"></i></button>

                </div>
            </div>
        </div>
    </div>
    <div class="carregando" style="color:green"></div>
    <div class="resultadoLoading" style="color: red;"></div>
<!-- </form> -->

<hr>
<div class="selecao">
    <span class="compra_valor"><strong>Modalidade selecionada: </strong><span class="mod_select resumoSpan"></span></span>
    <!-- <h2 class="compra_valor">Valor da compra: R$&nbsp;<span class="lote_select resumoSpan"></span> </h2> -->
</div>
<hr>