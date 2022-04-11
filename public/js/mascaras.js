(function() {
	if($('#cpf').length){
		VMasker(document.getElementById("cpf")).maskPattern('999.999.999-99');
	}

	if($('#cnpj').length){
		VMasker(document.getElementById("cnpj")).maskPattern('99.999.999/9999-99');
	}

	if($('#telefone').length){
		VMasker(document.getElementById("telefone")).maskPattern('(99) 9999-9999');
	}

	if($('#celular').length){
		VMasker(document.getElementById("celular")).maskPattern('(99) 99999-9999');
	}

	if($('input#cep').length){
		VMasker(document.getElementById("cep")).maskPattern('99999-999');
	}

	if($('input#pag_valor').length){
		VMasker(document.getElementById("pag_valor")).maskMoney({zeroCents: true});
	}
})();