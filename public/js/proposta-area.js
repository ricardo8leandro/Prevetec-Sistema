$(document).on('click','#btnAdicionarArea',function(){

	$('#formAdicionarArea').slideToggle();

	$(this).fadeToggle();

});



$(document).on('click','#btnConfirmarAddArea',function(){

	

	var res = false;

	if(editarArea > 0) {
		res = atualizarArea();
	}else{
		res = adicionarArea();
	}

	if(res){
		$('#formAdicionarArea').slideUp();
		$('#btnAdicionarArea').fadeIn();
		limparCamposFormAddArea();	
	}

	$('#opt_area_'+area_id).css('display','none');
	editarArea = 0;
});

$(document).on('click','#btnCancelarAddArea',function(){
	$('#formAdicionarArea').slideUp();
	$('#btnAdicionarArea').fadeIn();
	limparCamposFormAddArea();
});

function limparCamposFormAddArea(){
	$("#area").val( $('option:contains("Selecione a área")').val() );
	$("#anexo").val( $('option:contains("Selecione o nivel")').val() );
	$('#telhadoM').val( $('option:contains("SIM")').val());
	$('#estruturaM').val(  $('option:contains("SIM")').val() );
	$('#usaCTA').val( $('option:contains("SIM")').val() );
}

function pegaDadosFormArea(){
	/* passa os valores do form para variaveis */
	area_id 	= $('#area').children("option:selected").val();
	area_nome 	= $('#area ').children("option:selected").html();
	area_nome 	= area_nome.trim();
	telhadoM	= $('#telhadoM').val();
	estruturaM	= $('#estruturaM').val();
	usaCTA		= $('#usaCTA').val();
	anexo_id 	= $('#anexo').children("option:selected").val();

	var camposPreenchidos1 = true;

	/* verifica se uma area foi selecionada */
	if(area_id == 0 || area_id == ""){
		alert('Selecione a área');
		camposPreenchidos1 = false;
	}

	/* verifica se um nivel(anexo) foi selecionado */
	if(anexo_id == 0 || anexo_id == ""){
		alert('Selecione o nivel');
		camposPreenchidos1 = false;
	}

	return camposPreenchidos1;
}

function atualizarArea(){

	pegaDadosFormArea();

	if(pegaDadosFormArea()){

		var area = areas['area_' + editarArea];
		salvarArea();

		$('#area_'+ editarArea +" .area-name").html(area_nome);
		$('#area_'+ editarArea).attr('data-id',area_id);
		$('#area_'+ editarArea).attr('id','area_' + area_id);

		/* passando para o novo obj e limpando o antigo*/
		areas['area_'+ editarArea ] = {};
		areas['area_' + area_id] = area;

		return true;
	}

	return false;
}

function adicionarArea(){

	if(pegaDadosFormArea()){
		salvarArea();
		carregarEstrutura('area', montarEstruturaArea);
		return true;
	}

	return false;
}

function montarEstruturaArea(conteudo){
	conteudo = conteudo.split('{{id}}').join(area_id);
	conteudo = conteudo.replace("{{AREA.NOME}}",area_nome);

	$('.list-area').append(conteudo);
	$('#opt_area_'+area_id).attr('selected',false);
	$('#area_'+area_id+' .list-servico').sortable();
}

$(document).on('click','.editArea',function(){

	area_id 	= $(this).parent().parent().attr('id');

	editarArea 	= area_id.split("_")[1];

	carregarFormArea(area_id);

	$('#btnAdicionarArea').trigger('click');

});



/******************************************

 * funcoes para manipular o objeto AREAS

 */

function carregarFormArea(area_id){

	$("#area").val( areas[area_id]['id'] );

	$('#telhadoM').val( areas[area_id]['telhado'] );

	$('#estruturaM').val( areas[area_id]['estrutura'] );

	$('#usaCTA').val( areas[area_id]['usaCTA'] );

	$('#anexo').val( areas[area_id]['anexo'] );

	$('#opt_'+area_id).css('display','');

}



function salvarArea(){

	areas['area_'+area_id] = {
		'id' : area_id,
		'anexo': anexo_id,
		'telhado': telhadoM,
		'estrutura': estruturaM,
		'usaCTA': usaCTA,
		'servicos': {}
	}

	console.log("salvarArea:");
	console.log(areas['area_'+area_id]);
}

function excluirArea(id){

	if(propostaData['proposta_id']){

		$.ajax({
			url: PAINEL+'proposta/removerArea',
			method: 'post',
			dataType: 'html',
			data: {'area': id, 'proposta': propostaData['proposta_id'] },
			success: function(data){

			},
			error: function(data){
				console.log('erro');
				console.log(data);
			}
		});
	}

	areas['area_'+ id ] = {};
}

$(document).on('click','.removeArea',function(){
	var id = $(this).parent().parent().attr('data-id');
	$('#opt_area_'+area_id).css('display','');
	$(this).parent().parent().remove();
	excluirArea(id);

});

var mostrouLoading = false;

function setAreaIndices(){

	let i = 0;

	console.log("setAreaIndices");

	$('#btnGerarProposta').attr('disabled','disabled');

	console.log(propostaData);

	$('.list-area > li').each(function(){

		var id = $(this).attr('data-id');
		
		console.log("id: "+ id);
		console.log(areas);
		console.log(areas['area_'+ id]);

		areas['area_'+ id]['indice'] = i;


		if(setServicoIndices(id)){
			var area = areas['area_'+ id];

			i++;

			$.ajax({
				url: PAINEL+'proposta/ajax-areas',
				method:'post',
				dataType:'html',
				data:{'area': area },
				async: false,
				success: function(data){
					console.log('successo');
					console.log(data);
				},
				error: function(data){
					console.log('erro ao enviar as areas para o backend:');
					console.log(data);
				},
				beforeSend: function(){
					if(!mostrouLoading){
						mostrouLoading = true;
						$('body').append('<div class="loading-container"><div class="loading">'+
			            '<div class="l1"><div></div></div><div class="l2"><div></div></div>'+
			            '<div class="l3"><div></div></div><div class="l4"><div></div>'+
			            '</div></div></div>');
						$('.loading-container,.loading').css('display','block');
						$('.loading-container').css('opacity','0.5');
					}
				}
			});
		}
	});

	mostrouLoading = false;

	return true;
}

function setServicoIndices(id_area){

	let i = 0;

	$('#area_'+ id_area + ' .list-servico li').each(function(){
		let serv_id = $(this).attr('data-id');
		areas['area_'+id_area]['servicos']['servico_'+serv_id]['indice'] = i;
		i++;
	});

	return true;
}