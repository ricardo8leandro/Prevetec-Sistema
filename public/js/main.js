$(document).ready(function(){
	$('.init_desc').trigger('click');
});

$(document).on('submit','#formLogin',function(e){
	$('.btnSubmit').prop('disabled',true);
	e.preventDefault();
	var form = $(this).serialize();
	$.ajax({
		url: AUTH +'login',
		method: 'post',
		dataType: 'json',
		data: form,
		success: function(json){
			console.log(json);
			if(json.status  == 1){
				window.location = json.redirect;
			}else{
				alert(json.msg);
				$('.btnSubmit').prop('disabled',false);
			}
		},
		error: function(data){
			console.log(data);
			$('.btnSubmit').prop('disabled',false);
		}
	});
});

$(document).on('submit','#formCadastrar',function(e){
	e.preventDefault();
	$('.btnSubmit').prop('disabled',true);
	var form = $(this).serialize();
	$.ajax({
		url: PAINEL + url_cad_edit + 'novo',
		method: 'post',
		dataType: 'json',
		data: form,
		success: function(json){
			alert(json.msg);
			if(json.status  == 1){				
				// $('#formCadastrar').trigger("reset");
				location.reload();
			}

			$('.btnSubmit').prop('disabled',false);
		},
		error: function(data){
			console.log(data);
			$('.btnSubmit').prop('disabled',false);
		}
	});
});

$(document).on('submit','#formEditar',function(e){
	
	e.preventDefault();
	var form = $(this).serialize();
	$('.btnSubmit').prop('disabled',true);

	if($('#pw1').length && $('#pw1') != ""){
		if($('#pw1').val() != $('#pw2').val()){
			alert("As senhas devem ser iguais!");
			return;
		}
	}

	$.ajax({
		url: PAINEL + url_cad_edit +'editar',
		method: 'post',
		dataType: 'json',
		data: form,
		success: function(json){
			alert(json.msg);
			if(json.status  == 1) location.reload();
		},
		error: function(data){
			console.log(data);
			$('.btnSubmit').prop('disabled',false);
		}
	});
});

$(document).on('click','.btnDelete',function(){
	$('.btnConfirmDelete').attr('value',$(this).attr('value'));
	$('#modalExcluir').modal('show');
});

$(document).on('click','.btnConfirmDelete',function(){

	if(url_delete.lengt < 1){
		url_delete = '';
	}
	var id = $(this).attr('value');

	$.ajax({
		url:url_delete,
		method:'post',
		dataType: 'json',
		data: {'id':id},
		success: function(json){
			// console.log(json);
			alert(json.msg);
			if(json.status == 1){
				location.reload();
			}else{
				console.log(json);
			}
		},
		error: function(data){
			alert("Ops, nao foi possivel enviar a requisição");
			console.log(data);
		}
	});
});

if($('select#estado').length){
	buscaCidadePorEstado($('select#estado').val());
}

$(document).on('change','select#estado',function(){
	buscaCidadePorEstado($(this).val());
});

var carregou_cidade = 1;
function buscaCidadePorEstado(id){
	$.ajax({
		url: DIR_PAGE + '/Cidades/findOptions/'+id,
		method:'post',
		dataType:'html',
		success: function(cidades){
			$('select#cidade').html(cidades);

			if(tem_cidade > 0 && carregou_cidade === 1){
				$('select#cidade').val(tem_cidade);
			}

			carregou_cidade++;
		},
		error: function(data){
			console.log(data);
		}
	});
}

function montaSelectCidades(data){
	var lista = "<option disabled>Selecione uma cidade</option>";

	for(var i = 0; i < data.length; i++){
		var cd = data[i].cd_cidade;
		var nome = data[i].nm_cidade;
		var selected = "";
		if(tem_cidade == cd){
			selected =  "selected";
		}
		lista += "<option value='"+cd+"' "+selected+">";
		lista += nome;
		lista += "</option>";
		$('select#cidade').html(lista);
	}
}

//manipulando grupo de usuarios e chefia
$(document).ready(function(){
	if($('select#grupo').length){

		var pro  = $(this).find(':selected').attr('profissional');
		if(pro == "sim"){
			$('.chefia').slideDown();
			$('.cargo').slideDown();
		}else{
			$('.chefia').slideUp();
			$('.cargo').slideUp();
			$("#cargo").val($("#cargo option:first").val());
			$("#chefia").val($("#chefia option:first").val());
		}

		var prof2  = $(this).find(':selected').attr('engenheiro');


		if(prof2 == 'sim'){
			$('.crea').slideDown();	
		}

		$(document).on('change','select#grupo',function(){
			var pro  = $(this).find(':selected').attr('profissional');

			if(pro == "sim"){
				$('.chefia').slideDown();
				$('.cargo').slideDown();

			}else{
				$('.chefia').slideUp();
				$('.cargo').slideUp();
				$("#cargo").val($("#cargo option:first").val());
				$("#chefia").val($("#chefia option:first").val());
			}

			var prof2  = $(this).find(':selected').attr('engenheiro');

			if(prof2 == "sim"){
				$('.crea').slideDown();	
			}else{
				$('.crea').slideUp();
				$('.crea').val('');
			}
		});
	}
});


$(document).on('submit','#formRecuperarSenha', function(e){
	e.preventDefault();

	var form = $(this).serialize();

	$.ajax({
		url: DIR_PAGE + "Home/recuperar-senha",
		method: 'post',
		dataType: 'json',
		data: form,
		success: function(json){
			alert(json.msg);
		},
		error: function(error){
			console.log(error);
		}
	});
});

$(document).on('submit','#formRedefinirSenha', function(e){
	e.preventDefault();

	var form = $(this).serialize();

	if($('#senha1').val() != $('#senha2').val()){
		alert("As senhas devem ser iguais!");
		return;
	}

	$.ajax({
		url: DIR_PAGE + "Home/redefinir-senha",
		method: 'post',
		dataType: 'json',
		data: form,
		success: function(json){
			alert(json.msg);
			if(json.status){
				 window.location.href = DIR_PAGE;
			}
		},
		error: function(error){
			console.log(error);
		}
	});
});
