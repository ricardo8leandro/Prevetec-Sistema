var listaServicos;
var idAreaSelecionada = 0;
var idServicoSelecionado = 0;

function modalListaServicos(id){
	areaManipulada = id;
	requestListaServicos(montaModal);
}

function requestListaServicos(onSuccess){
	
	var servicosFiltrados = areas['area_' + areaManipulada]['servicos'];
		
	$.ajax({
		url: PAINEL+'proposta/listaServicos',
		method: 'post',
		dataType:'json',
		data: servicosFiltrados,
		success: function(servicos){
			listaServicos = servicos;
			onSuccess(servicos);
		},
		error: function(error){
			console.log(error);
		}
	});
}

function montaModal(servicos){
	
	var opts = "";
	if(servicos.length){
		servicos.forEach(function(data, index){
			var id = data['cd_servico'];
			opts +="<option value='"+id+"' id='servico_"+id+"''>";
			opts += data['ds_titulo'];
			opts += "</option>";
		});
	}
	$('.select-servicos').html(opts);
	$('.modal-lista-servicos').modal();
	
}

$(document).on('click','.btnConfirmaSelectServico',function(){
	
	$('.select-servicos option:selected').each(function(){
		let id = $(this).val();
		
		for(l = 0; l < listaServicos.length; l++){
			if(listaServicos[l]['cd_servico'] == id ){
				
				let servico = {
					'id': id,
					'ds_titulo': listaServicos[l]['ds_titulo'],
					'qtd': '',
					'dimensao': '',
					'obs' : ''
				};

				areas['area_'+areaManipulada]['servicos']['servico_'+id] = servico;
				break;
			}
		}
	});

	carregarEstrutura('servico', montaEstruturaServico);
	$('.modal-lista-servicos').modal('hide');
});

$(document).on('click','.btnCancelaSelectServico',function(){
	$('.modal-lista-servicos').modal('hide');
});

function montaEstruturaServico(estruturaHTML){
	var conteudo = "";
	for(s in areas['area_'+areaManipulada]['servicos']){
		
		let item = "";
		let servico = areas['area_'+areaManipulada]['servicos'][s];
		
		item = estruturaHTML.replace("{{SERVICO.ID}}", servico['id']);
		item = item.replace("{{SERVICO.NOME}}",servico['ds_titulo']);
		conteudo += item;
	}
	$('#area_'+areaManipulada+" .list-servico").html(conteudo);
}

$(document).on('click','.removeServico',function(){
	let servico_id = $(this).parent().attr('data-id');
	let area_id = $(this).parent().parent().parent().parent().attr('data-id');
	
	if(propostaData['proposta_id']){
		$.ajax({
			url: PAINEL+'proposta/removeAreaServico',
			method: 'post',
			dataType: 'html',
			data:{'area':area_id,
				  'servico': servico_id,
				  'proposta': propostaData['proposta_id']
			},
			success: function(data){
				console.log(data);
			},
			error: function(data){
				console.log('error');
				console.log(data);
			}
		});
	}

	servico = areas['area_'+ area_id]['servicos']['servico_'+servico_id] = {};
	$(this).parent().remove();
});


$(document).on('click','.editServico',function(){
	idAreaSelecionada = $(this).parent().parent().parent().parent().attr('data-id');
	idServicoSelecionado = $(this).parent().attr('data-id');
	requestListaServicos(modalEditaServico);
});

function modalEditaServico(servicos){
	
	var opt = "";
	let area = idAreaSelecionada;
	let servico_id = idServicoSelecionado;
	let servico = areas['area_'+area]['servicos']['servico_'+servico_id];

	// $('#editServico-servico').html(opt);
	$('#editServico-titulo').val(servico['ds_titulo']);
	$('#editServico-qtd').val(servico['qtd']);
	$('#editServico-dimensao').val(servico['dimensao']);
	CKEDITOR.instances['editServico-obs'].setData(servico['obs']);

	$('.modal-edita-servico').modal();
}

$(document).on('click','.btnCancelaEditServico',function(){
	$('.modal-edita-servico').modal('hide');
});

$(document).on('click','.btnConfirmaEditServico',function(){
	
	let area = idAreaSelecionada;
	let servico = idServicoSelecionado;
	let qtd = $('#editServico-qtd').val();
	let dimensao = $('#editServico-dimensao').val();
	let obs = CKEDITOR.instances['editServico-obs'].getData();

	areas['area_'+area]['servicos']['servico_'+servico]['qtd'] = qtd;
	areas['area_'+area]['servicos']['servico_'+servico]['dimensao'] = dimensao;
	areas['area_'+area]['servicos']['servico_'+servico]['obs'] = obs;
	$('.modal-edita-servico').modal('hide');
});
