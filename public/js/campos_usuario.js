verificaTipo($('select#grupo').val());

function verificaTipo(opc){
	if( opc == "" || opc == null){
		desabilitarTodos();
	}else if(opc == 6){
		habilitarCamposCliente();
	}else if(opc == 12){
		habilitarCamposFornecedor();
	}else{
		habilitarCamposProfissional(opc);
	}
	doctype(opc);
}

function doctype(opc){
	/*APENAS CPF (funcionarios)*/
	if(opc == 1 || opc == 2 || opc == 11 || opc == 13 || opc == 14){
		$('#div_cnpj').css('display','none');
		$('#div_cpf').prop('display','');
		$('#type_cpf').trigger('click');
	}

	/*CPF OU CNPJ (clientes, fornecedores e representantes)*/
	if(opc == 6 || opc == 12 || opc == 15){
		$('#div_cnpj').css('display','');
		$('#div_cpf').prop('display','');
	}
}

$(document).on('click','.doctype',function(){

	$('#doctype').attr('name',$(this).val());

	if($(this).val() == "cpf"){
		VMasker(document.getElementById("doctype")).maskPattern('999.999.999-99');
	}else{
		VMasker(document.getElementById("doctype")).maskPattern('99.999.999/9999-99');
	}
});

$(document).on('change','select#grupo',function(){
	verificaTipo($(this).val());
});

function desabilitarTodos(){
	$('.pro').css('display','none');
	$('.for').css('display','none');
	$('.cli').css('display','none');

	$('.pro-inpt').attr('required',false);
	$('.for-inpt').attr('required',false);
	$('.cli-inpt').attr('required',false);
}

function habilitarCamposCliente(){
	$('.pro-inpt').attr('required',false);
	$('.for-inpt').attr('required',false);
	$('.cli-inpt').attr('required',false);

	$('.pro').css('display','none');
	$('.for').css('display','none');
	$('.cli').css('display','block');
}

function habilitarCamposFornecedor(){
	$('.pro-inpt').attr('required',false);
	$('.cli-inpt').attr('required',false);
	$('.for-inpt').attr('required',false);

	$('.pro').css('display','none');
	$('.cli').css('display','none');
	$('.for').css('display','block');
}

function habilitarCamposProfissional(opc){
	$('.cli-inpt').attr('required',false);
	$('.for-inpt').attr('required',false);
	$('.pro-inpt').attr('required',false);

	if(opc == 11){
		$('#crea').attr('required',true);
	}

	$('.for').css('display','none');
	$('.cli').css('display','none');
	$('.pro').css('display','block');
}
