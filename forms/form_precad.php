<form id="frmPrecad" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label id="labelNome" for="name">Nome</label>
        <input type="text" id="nomef" name="nome" placeholder="Digite seu nome" />
    </div>
    <div class="form-group">
        <label id="labelEmail" for="email">E-mail</label>
        <input type="email" id="emailf" name="email" placeholder="Digite seu melhor e-mail" />
    </div>
    <div class="form-group">
        <label id="labelTelefone" for="phone">Telefone</label>
    </div>
    <input type="text" id="telefonef" name="telefone" class="seuphone" placeholder="Número de Whatsapp" minlength="15" maxlength="15"/>
    <!-- <input type="text" id="telefonef" name="telefone" class="seuphone" placeholder="Número de Whatsapp" minlength="15" maxlength="15" onblur="validarCelular(this.value);" onkeyup="handlePhone(event)"/> -->

    <input id="btn-inscr" type="submit" class="btn" value="Entrar no Grupo ⭐" />
    
</form>