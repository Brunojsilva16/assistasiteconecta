<div class="card-form__inner">

    <div class="row">
        <div class="card-input">
            <label for="cardNumber" class="card-input__label">N&uacute;mero do cart&atilde;o</label>
            <input type="text" id="cardNumber" name="cardNumber" class="card-input__input" autocomplete="off" maxlength="19">
        </div>
    </div>
    <div class="card-form__row">
        <div class="card-form__col">
            <div class="card-form__group">
                <label for="cardMonth" class="card-input__label">Validade</label>

                <select name="cardMonth" id="cardMonth" data-ref="cardDate" class="card-input__input -select">
                    <option value="" disabled="disabled" selected="selected">Mês</option>
                    <option value="01">
                        01
                    </option>
                    <option value="02">
                        02
                    </option>
                    <option value="03">
                        03
                    </option>
                    <option value="04">
                        04
                    </option>
                    <option value="05">
                        05
                    </option>
                    <option value="06">
                        06
                    </option>
                    <option value="07">
                        07
                    </option>
                    <option value="08">
                        08
                    </option>
                    <option value="09">
                        09
                    </option>
                    <option value="10">
                        10
                    </option>
                    <option value="11">
                        11
                    </option>
                    <option value="12">
                        12
                    </option>
                </select>

                <select name="cardYear" id="cardYear" data-ref="cardDate" class="card-input__input -select">
                    <option value="" disabled="disabled" selected="selected">Ano</option>
                    <option value="2024">
                        2024
                    </option>
                    <option value="2025">
                        2025
                    </option>
                    <option value="2026">
                        2026
                    </option>
                    <option value="2027">
                        2027
                    </option>
                    <option value="2028">
                        2028
                    </option>
                    <option value="2029">
                        2029
                    </option>
                    <option value="2030">
                        2030
                    </option>
                    <option value="2031">
                        2031
                    </option>
                    <option value="2032">
                        2032
                    </option>
                    <option value="2033">
                        2033
                    </option>
                    <option value="2034">
                        2034
                    </option>
                    <option value="2035">
                        2035
                    </option>
                    <option value="2036">
                        2036
                    </option>
                    <option value="2037">
                        2037
                    </option>
                    <option value="2038">
                        2038
                    </option>
                    <option value="2039">
                        2039
                    </option>
                    <option value="2040">
                        2040
                    </option>

                </select>

            </div>
        </div>
        <div class="card-form__col -cvv">
            <div class="card-input">
                <label for="cardCvv" class="card-input__label"><span style="color: red;">*</span>CVC</label>
                <input type="password" class="card-input__input" name="cardCvv" id="cardCvv" v-mask="'####'" maxlength="4" v-model="cardCvv" v-on:focus="flipCard(true)" v-on:blur="flipCard(false)" autocomplete="off">
            </div>
        </div>
    </div>

    <div class="card-input">
        <label for="cardNparcelas" class="card-input__label">Parcelas s/juros</label>
        <select class="card-input__input" id="cardNparcelas" name="cardNparcelas" onchange="onchangeSelec(this);">
        </select>
    </div>

    <div>
        <p style="font-size: 20px; font-weight:700">Dados do titular do cartão</p>
    </div>

    <div class="card-input">
        <label for="cardName" class="card-input__label">Nome completo</label>
        <input type="text" id="cardName" name="cardName" class="card-input__input" v-model="cardName" v-on:focus="focusInput" v-on:blur="blurInput" data-ref="cardName" autocomplete="off">
    </div>


    <div class="card-input">
        <label for="cardNcpf" class="card-input__label">CPF</label>
        <input type="text" id="cardNcpf" class="card-input__input" name="cardNcpf" maxlength="14">
    </div>

    <div class="card-input">
        <label for="cardNemail" class="card-input__label">E-mail</label>
        <input type="email" id="cardNemail" class="card-input__input" name="cardNemail">
    </div>

    <div class="card-form__row">
        <div class="card-form__col">
            <div class="card-form__group row">

                <div class="card-input col-4">
                    <label for="cardNum" class="card-input__label">DDD</label>
                    <input type="text" id="cadddd" name="cadddd" v-mask="'####'" class="card-input__input" maxlength="2"  placeholder="Ex.: 81">
                </div>

                <div class="card-input col-8">
                    <label id="labelTelefone" for="phone">Telefone</label>
                    <input type="text" id="cadfone" name="cadfone" class="card-input__input" placeholder="99999 9999" maxlength="10"/>
                </div>

            </div>
        </div>
    </div>

    <div class="card-input">
        <div class="input-group">
            <input type="text" class="form-control" id="cardCep" name="cardCep" placeholder="busca cep" aria-label="busca cep" maxlength="8">
            <button class="btn btn-outline-info" id="bottonCep" type="button">Buscar</button>
        </div>
    </div>

    <div class="card-input">
        <label for="cardRua" class="card-input__label">Rua</label>
        <input type="text" id="cardRua" class="card-input__input" name="cardRua" placeholder="Ex.: Av. Brasil">
    </div>


    <div class="card-form__row">
        <div class="card-form__col">
            <div class="card-form__group row">

                <div class="card-input col-4">
                    <label for="cardNum" class="card-input__label">Número</label>
                    <input type="text" id="cardNum" class="card-input__input" name="cardNum" placeholder="Ex.: 1384">
                </div>

                <div class="card-input col-8">
                    <label for="cardComp" class="card-input__label">Complemento <span>Opcional</span></label>
                    <input type="text" id="cardComp" class="card-input__input" name="cardComp" placeholder="Ex.: apartamento 73">
                </div>

            </div>
        </div>
    </div>


    <div class="card-input">
        <label for="cardBairro" class="card-input__label">Bairro</label>
        <input type="text" id="cardBairro" class="card-input__input" name="cardBairro" placeholder="Bairro">
    </div>

    <div class="card-form__row">
        <div class="card-form__col">
            <div class="card-form__group row">

                <div class="card-input col-8">
                    <label for="cardCidade" class="card-input__label">Cidade</label>
                    <input type="text" id="cardCidade" class="card-input__input" name="cardCidade" placeholder="Cidade">
                </div>
                <div class="card-input col-4">
                    <label for="cardEstado" class="card-input__label">Estado</label>
                    <input type="text" id="cardEstado" class="card-input__input" name="cardEstado" placeholder="Estado">
                </div>

            </div>
        </div>
    </div>

    <input id="pag_idpartipante" name="idpart" type="hidden">
    <input id="pag_codpc" name="codparceiro" type="hidden" value="SEMCODIGO">
    <input id="cat_catcomp" name="catcompra" type="hidden">
    <input id="cat_nParcela" name="catnParcela" type="hidden">

    <div id="carregando" style="color:green"></div>
    <div id="resultado"></div>

    <input type="submit" name="btnEnviar" id="btnEnviar" class="card-form__button" value="Pagamento" style="cursor: pointer;">
    <span class="segure"> *CVC - código de segurança do cartão, um número de três dígitos no verso.</span>
</div>