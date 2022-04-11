var idModelo;
var ModeloProposta = {};

$(document).on('click','#btnAplicarModelo',function(){
	indice = $('#condPagto').val();
	idModelo = $('#condPagto').attr('modelo');
	
	if(EDITOR_NAME == 'ckeditor'){
		CKEDITOR.instances['pagtoConteudo'].setData(modelosPagto[indice]['ds_descricao']);
	}else{
		// console.log(modelosPagto[indice]['ds_descricao']);
		// tinymce.get("pagtoConteudo").execCommand('mceInsertContent', false,modelosPagto[indice]['ds_descricao']);
		// tinymce.setContent(modelosPagto[indice]['ds_descricao']);
		tinymce.activeEditor.setContent(modelosPagto[indice]['ds_descricao'], {format: 'html'});
	}
	
});