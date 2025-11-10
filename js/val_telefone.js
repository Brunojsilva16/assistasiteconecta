function validarCelular(telefone) {

	// ExpressÃ£o regular para validar o nÃºmero de telefone com DDD
    const regex = /^(\(?[1-9]{2}\)? ?(9{1})([7-9]{1})[0-9]{3}-[0-9]{4})$/;
	
	// Verifica se o nÃºmero de telefone corresponde Ã  expressÃ£o regular
	if (regex.test(telefone)) {
		document.getElementById('labelTelefone').innerHTML = "Telefone";
	}
	else {
		document.getElementById('labelTelefone').innerHTML = "<span class='text-warning'>Telefone inválido, verifique o número digitado</span>";
		return false;
	}

}

const handlePhone = (event) => {
	let input = event.target
	input.value = phoneMask(input.value)
}

const phoneMask = (value) => {
	if (!value) return ""
	value = value.replace(/\D/g, '')
	value = value.replace(/(\d{2})(\d)/,"($1) $2")
	value = value.replace(/(\d)(\d{4})$/,"$1-$2")
	return value
}