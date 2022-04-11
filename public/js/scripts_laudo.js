var itens = {'itens':{},'modelo':0};

$('.sortable, .group_items').sortable();

$(document).on('submit','#formOrdenarIndice',function(e){
	e.preventDefault();

	$('.btnSubmit').prop('disabled',true);
	
	montaForm();
	itens['modelo'] = $('#id_laudo').val();

	// console.log(itens);
	// return;

	$.ajax({
		url: PAINEL + url_cad_edit +'indice',
		method: 'post',
		dataType: 'json',
		data: itens,
		success: function(data){
			alert(data.msg);
			$('.btnSubmit').prop('disabled',false);
		},
		error: function(error){
			console.log('erro');
			console.log(error);
			$('.btnSubmit').prop('disabled',false);
		}
	});
});

function montaForm(){
	
	var indice = 0;
	var titulo = 0;

	$('.sumario-titulo > li').each(function(){
		var cd = $(this).attr('item_id');
		
		var id_titulo = $(this).attr('id');

		itens['itens'][indice] = {
			'item' : cd,
			'indice' : titulo
		};

		titulo++;
		var sub1 = 0;

		$('#'+id_titulo+' > .panel-body > .sumario-sub1 > li').each(function(){

			indice++;
			
			var cd = $(this).attr('item_id');
			var id_sub1 = $(this).attr('id');

			itens['itens'][indice] = {
				'item' : cd,
				'indice' : sub1
			};

			sub1++;
			var sub2 = 0;

			$('#'+id_sub1+' > .sumario-sub2 > li').each(function(){
				indice++;

				var cd = $(this).attr('item_id');

				itens['itens'][indice] = {
					'item' : cd,
					'indice' : sub2
				};
				sub2++;
			});
		});

		indice++;
	});
}

$(document).on('submit','#formCadastrarLaudo',function(e){
	e.preventDefault();
	$('.btnLaudo').prop('disabled',true);
	var form = $(this).serialize();
	$.ajax({
		url: PAINEL + url_cad_edit + 'novo',
		method: 'post',
		dataType: 'json',
		data: form,
		success: function(json){
			console.log(json);
			alert(json.msg);
			if(json.status  == 1){
				location.href = PAINEL + "laudo/laudo/"+json['id']+'/1';
			}
		},
		error: function(data){
			console.log(data);
			$('.btnLaudo').prop('disabled',false);
		}
	});
});

$(document).on('submit','#formEditarLaudo',function(e){
	
	e.preventDefault();
	var form = $(this).serialize();
	$('.btnLaudo').prop('disabled',true);

	$.ajax({
		url: PAINEL + url_cad_edit +'editar',
		method: 'post',
		dataType: 'json',
		data: form,
		success: function(json){
			alert(json.msg);
			if(json.status  == 1){
				location.href = PAINEL + "laudo/laudo/"+json['id']+'/1';
			}
		},
		error: function(data){
			console.log(data);
			$('.btnLaudo').prop('disabled',false);
		}
	});
});

if(typeof cd_estado === 'undefined'){
	cd_estado = 0;
}

$(document).on('click','#btnAddArt',function(){
	$('#art').trigger('click');
});

$(document).on('click','#btnAddCert1',function(){
	$('#cert1').trigger('click');
});

$(document).on('click','#btnAddCert2',function(){
	$('#cert2').trigger('click');
});

$(document).ready(function(){

	if(typeof actionStatus != 'undefined'){
	    if(actionStatus['status'] != ''){
	        alert(actionStatus['msg']);
	    }
	}
});