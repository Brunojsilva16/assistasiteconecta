<div>
    <p style="font-size: 22px;font-weight:700;padding-bottom: 20px;padding-top: 10px;text-align: center;color: #ff8f00;">Pré-inscrição confirmada!*</p>



    <p style="font-size: 25px; font-weight:700; padding-bottom: 20px;">Resumo da compra</p>
</div>

<div id="cupomParceiro" class="input-group mb-2">
    <div class="input-group">
        <input type="text" class="form-control" id="cupomParc" name="cupomParc" placeholder="Código de Parceiro" aria-label="Código de Parceiro" maxlength="20">
        <button class="btn btn-outline-secondary" id="botCupom" type="button">VALIDAR</button>
    </div>
</div>

<div>
    <p style="font-size: 21px; font-weight:700">Nome do participante: <br> <span style="font-size: 18px;" class="resumoSpan" id="mpartipante"></span></p>
    <p style="font-size: 21px; font-weight:700">Modalidade da compra: <br> <span style="font-size: 18px;" class="resumoSpan" id="mcompra"></span></p>
    <!-- <p style="font-size: 22px; font-weight:700; margin-bottom: 0px;">Valor da compra: R$&nbsp;<span class="resumoSpan" id="vcompra"></span></p> -->
    <p style="font-size: 16px; font-weight:700"><span class="resumoSpan" id="vcodigo"></span></p>
</div>

<div class="row">
    <div style="margin: 10px 0px;" class="col-12 align-self-start upp doww">
        <div class="row align-self-start">

            <input id="value_resumo" name="vresumo" type="hidden">
            <input id="id_resumo" name="idresumo" type="hidden">
            <input id="cat_compra" name="catcompra" type="hidden">
            <input id="cod_parceiro" name="codparceiro" type="hidden" value="SEMCODIGO">

            <div class="col-12 upp">
                <!-- <input id="sbmlote_one" type="submit" class="btn btn-success" value="Continuar" /> -->
                <!-- INICIO DO BOTAO PAGBANK -->
                <div id="txtclic"></div>
                <div id="botaopagamento">
                    <div id="txtcartao"></div>

                </div>

                <div id="precce">
       
                </div>

            </div>
        </div>
    </div>
</div>










<!-- <hr>
Dados do dono do cartão

<div id="cardHolderDataFields">
    <div id="cardHolderData" class="holderData double-columns first-block">
        <h1>Dados do dono do cartão</h1>





        <div class="holderCPFField field  a ">
            <label for="holderCPF">
                CPF do dono do cartão
            </label>
            <input class="bigger" type="text" id="holderCPF" name="holderCPF" value="" data-title="CPF do dono do cartão" maxlength="14" autocomplete="off">
        </div>

        <div class="holderPhoneField field ">
            <label for="holderAreaCode">
                Celular do dono do cartão
            </label>

            <input class="small" type="text" data-autotab-target="holderPhone" maxlength="2" id="holderAreaCode" name="holderAreaCode" value="" data-title="Celular do dono do cartão">
            <input class="big" type="text" maxlength="9" id="holderPhone" name="holderPhone" value="" data-title="Celular do dono do cartão">
        </div>
        <input type="hidden" name="holderCanEditPhone" value="true">


        <div class="holderBornDateField field  a ">
            <label for="holderBornDate">
                Data de nascimento
            </label>
            <input class="medium" type="text" id="holderBornDate" name="holderBornDate" value="" data-title="Data de nascimento">
            <p class="insertion-guide">Ex.: 20/05/1980</p>
        </div>

        <div class="clear-all"></div>
    </div>
</div>



Resumo do pedido

<table>
    <thead>
        <tr>
            <th>Descrição</th>
            <th>Valor</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <h3 title="Plano Fibra 30M">Plano Fibra 30M</h3>
                Quantidade: 1<br>
                Valor do item: R$ 69,99
            </td>
            <td>R$<strong>69,99</strong></td>
        </tr>

    </tbody>
    <tfoot>
        <tr id="totalRow">
            <td>
                <h3>Total a pagar</h3>
            </td>
            <td>
                <span id="cartTotalAmount">R$<strong>69,99</strong></span>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <p class="flagCountry flagCountry-Brazil">Esta compra está sendo feita no <strong>Brasil.</strong></p>
            </td>
        </tr>
    </tfoot>
</table> -->