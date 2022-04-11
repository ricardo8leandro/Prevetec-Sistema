var step = 1;
var area_id;
var area_nome = "";
var telhadoM;
var estruturaM;
var usaCTA;
var anexo_id;
var areaManipulada = 0;
var editarArea = 0;
var servicos_area = {};

if(propostaAprovada != 1){
	$('.sortable, .group_items').sortable(); 
}

$(document).on('click','#addarea', function(){
	var newItem = $('.area_clonavel').clone(true).removeClass('area_clonavel');
	$(newItem).appendTo('.list-area');
});

function setStep(nr){
	step = nr;
	func = "step_" + nr;
	window[func](nr);
	carregaDataProposta();
}

function Campos(nr){
	$(".proposta-conteudo").css('display','none');
	$('.btn-step').removeClass('btn-success');
	$('.btn-step').addClass('btn-info');

	$('#step'+nr+'-conteudo').css('display','block');
	$('#step'+nr).removeClass('btn-info');
	$('#step'+nr).addClass("btn-success");
	$('#step'+nr).attr('disabled',false);
}

function step_1(nr){
	Campos(nr);
	$('.divProximoStep').css('display','block');
	$('.divGeraProposta').css('display','none');
}

function step_2(nr){

	if( camposPreenchidos() ){
		$('#alertaCampos').css('display','none');
		Campos(nr);
	}else{
		$('#alertaCampos').css('display','block');
		step--;
		Campos(step);
		return;
	}

	$('.divProximoStep').css('display','block');
	$('.divGeraProposta').css('display','none');
}

function step_3(nr){
	propostaData['areas'] = areas;
	Campos(nr);

	$('.divProximoStep').css('display','block');
	$('.divGeraProposta').css('display','none');
}

function get_editor_content(elementId){
	if(EDITOR_NAME == 'ckeditor'){
		// console.log(CKEDITOR.instances['pagtoConteudo'].getData());
		return CKEDITOR.instances[elementId].getData();
	}else{
		return tinymce.get(elementId).getContent();
	}
}

function step3Completo(){

	let conteudo = get_editor_content('pagtoConteudo');
	
	let vPagto = $('#pag_valor').val();
	let conteudo_completo = Preenchido(conteudo);
	let valor_completo = Preenchido(vPagto);

	if( conteudo_completo && valor_completo) {
		carregaPropostaPagamento();
		return true;
	}
}

function Preenchido(campo){
	if(campo == null || campo == "" || campo == undefined){
		return false;
	}
	return true;
}

function step_4(nr){

	if(step3Completo()){
		$('#alertaCampos').css('display','none');
		Campos(nr);

		$('.divProximoStep').css('display','none');
		$('.divGeraProposta').css('display','block');
	}else{
		$('#alertaCampos').css('display','block');
		step--;
		Campos(step);
	}
}

$(document).on('click','#proximoStep',function(){
	step++;
	if(step > 4) step =4;
	setStep(step);
});

function camposPreenchidos(){

	var inputs = $('#step1-conteudo .form-control');
	var todosOsCamposPreenchidos = true;

	for(var i = 0; i < inputs.length; i++){

		var input_id = inputs[i]['id'];

		if(input_id == "prazoInicio" || input_id == "prazoExecucao"){
			var value = inputs[i]['value'];
		}else{
			var value = $('#'+input_id).find(":selected").val();	
		}

		if(value == "" || value == null) todosOsCamposPreenchidos = false;	
	}

	return todosOsCamposPreenchidos;
}

function carregarEstrutura(tipo, onSuccess){

	$.ajax({
		url: PAINEL+'proposta/carregarEstrutura/'+tipo,
		method:'post',
		dataType: 'html',
		success: function(html){
			onSuccess(html);
		},
		error: function(conteudo){
			alert('nao foi possivel carregar o conteudo');
			console.log(conteudo);
		}
	});
}

$(document).on('click','#btnGerarProposta',function(){

	var res = setAreaIndices();

	prop = propostaData;
	prop['areas'] = {};

	setTimeout(function(){
		$.ajax({
			url: PAINEL+'proposta/gerarProposta',
			method:'post',
			dataType:'json',
			data: prop,
			success: function(data){
				
				console.log(data);

				if(data.status == 1){
					alert('Proposta gerada com sucesso!');
					$('.c-pdf').css('display','block');	
					$('.href_pdf').attr('href',data['url']);
					propostaData['proposta_id'] = data['id_proposta'];
				}else{
					alert('Ops, não foi possivel gerar o PDF!');
				}

				$('#btnGerarProposta').attr('disabled',false);
			},
			error: function(data){
				alert("Ops, ocorreu um erro na geração do PDF!");
				console.log('erro ao gerar a proposta');
				console.log(data);
				$('#btnGerarProposta').attr('disabled',false);
			},
			complete: function(){
				$('.loading-container').remove();	
			}
		});
	},300);

	$('#btnGerarProposta').attr('disabled',false);
});

function carregaPropostaPagamento(){

	let vlPagto = $('#pag_valor').val();
	let opt_val = $('#condPagto').val();
	let condPagto = $('#pag_opt_'+opt_val).attr('modelo');
	let conteudo = get_editor_content('pagtoConteudo');

	propostaData['pagamento'] = {
		'valor' : vlPagto,
		'conteudo' : conteudo,
		'condicaoPag' : condPagto
	}
}

function carregaDataProposta(){

	if(editar != null && editar > 0) propostaData['proposta_id'] = editar;
	propostaData['cliente'] = $('#cliente').val();
	propostaData['tipoServico'] = $('#tipoServico').val();
	propostaData['tipoEdificio'] = $('#tipoEdificio').val();
	propostaData['ConfigPDF'] = $('#ConfigPDF').val();
	propostaData['documento'] = $('#documento').val();
	propostaData['engResponsavel'] = $('#engResponsavel').val();
	propostaData['status'] = $('#status').val();
	propostaData['prazoInicio'] = $('#prazoInicio').val();
	propostaData['prazoExecucao'] = $('#prazoExecucao').val();
	propostaData['regiao'] = $('#regiao').val();
	carregaPropostaPagamento();
}

$(document).on('click','.btnLink',function(){
	window.open( $(this).attr('href') , '_blank');
});

$(document).on('click','.btnPDFs',function(){
	window.location.href = PAINEL+'proposta/listar-proposta-pdfs/'+ $(this).attr('value');
});

/**
 * CARREGAR AS AREAS E SERVICOS PARA EDICAO
 */

 $(document).ready(function(){
 	if(typeof editar !== 'undefined' && editar != null && editar > 0){

	for(var i = 0; i < areasC.length; i++){

	    var servicos = areasC[i]['servicos'];

	    $('#opt_area_'+areasC[i]['cd_area']).css('display','none');

	    areas['area_'+ areasC[i]['cd_area']] = {
	        'id' : areasC[i]['cd_area'],
	        'anexo': areasC[i]['cd_anexo'],
	        'telhado': areasC[i]['cd_telhadp_metalico'],
	        'estrutura': areasC[i]['cd_estrutura_metalica'],
	        'usaCTA': areasC[i]['usa_cta'],
	        'indice': areasC[i]['cd_indice'],
	        'ds_titulo': areasC[i]['ds_titulo'],
	        'servicos': {}
	    }

	    for(var l = 0; l < servicos.length; l++){

	        var si = servicos[l]['cdservico'];

	        areas['area_'+ areasC[i]['cd_area'] ]['servicos']['servico_'+si] = {
	            'dimensao': servicos[l]['dsdimensao'],
	            'indice' :servicos[l]['cdindice'],
	            'qtd': servicos[l]['nrqtde'],
	            'obs': servicos[l]['dsobservacao'],
	            'id': servicos[l]['cdservico'],
	            'ds_titulo': servicos[l]['ds_titulo']
	        }
	    }

	}

	propostaData['areas'] = areas;

	console.log(propostaData['areas']);
	
	myLoop(0);

	carregaDataProposta();
}
 });

function myLoop(myL) {

	var indiceL = myL;

  	setTimeout(function() {
   		
   		loadAreasEditar(areasC[indiceL]['cd_area'],areasC[indiceL]['ds_titulo']);
   		
   		myL++;

    	if (myL < areasC.length ) myLoop(myL);

  	}, 350)
}

function loadAreasEditar(cd_area,nm_area){

	$.ajax({
        url: PAINEL+'proposta/carregarEstrutura/area',
        method: 'post',
        dataType: 'html',
        success: function(conteudo){

            conteudo = conteudo.split('{{id}}').join(cd_area);
            conteudo = conteudo.replace("{{AREA.NOME}}",nm_area);

            $('.list-area').append(conteudo);
            $('#opt_area_' + cd_area).attr('selected',false);

            if(propostaAprovada != 1){
            	$('#area_' + cd_area + ' .list-servico').sortable();
            }

            verificarDisableAllOptions();
            loadServicosEditar(cd_area);

            return 1;
        },
        error: function(erro){
            console.log('erro: ');
            console.log(erro);
        }
    });
}

function loadServicosEditar(cd_area){

	$.ajax({
        url: PAINEL+'proposta/carregarEstrutura/servico',
        method: 'post',
        dataType: 'html',
        success: function(estruturaHTML){

           	var conteudo = "";

			for(s in areas['area_'+cd_area]['servicos']){

				let item = "";
				let servico = areas['area_'+cd_area]['servicos'][s];

				item = estruturaHTML.replace("{{SERVICO.ID}}", servico['id']);
				item = item.replace("{{SERVICO.NOME}}",servico['ds_titulo']);
				conteudo += item;
			}

			$('#area_'+cd_area+" .list-servico").html(conteudo);



			verificarDisableAllOptions();
        },

        error: function(erro){
            console.log('erro: ');
            console.log(erro);
        }

    });
}

// APROVAR E RECUSAR PROPOSTA
$(document).on('click','.btnAprovarProposta', function(){
	var id = $(this).attr('value');
	propostaAceitaAjax('1',id);

});



$(document).on('click','.btnRecusarProposta', function(){

	var id = $(this).attr('value');

	propostaAceitaAjax('0',id);

});



function propostaAceitaAjax(acao, id){

	$.ajax({

		url: PAINEL+ 'proposta/proposta_aceita',

		method: 'post',

		dataType: 'html',

		data: {'status': acao,'id':id },

		success: function (data){

			alert(data);

			location.reload();

		},

		error: function(error){

			alert(error);

		}

	});

}



if(propostaAprovada == 1){

	disableAllOptions();

}



function disableAllOptions(){

	$('input').prop('disabled',true);

	$('select').prop('disabled',true);

	$('.btnAplicarModelo').prop('disabled',true);

	$('#pagtoConteudo').prop('disabled',true);

	$('#btnAdicionarArea').prop('disabled',true);

	$('#btnGerarProposta').remove();

}



function verificarDisableAllOptions(){

	if(propostaAprovada == 1){

		$('.btn-servico').remove();

		$('.panel-heading .fa').remove();

		$('.group_items li span').remove();

	}

}