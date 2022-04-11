<?php
	$itemId 		   = explode('_',$code)[0];
	$btnRemoveID 	   = 'id="btn_remove_'.$code.'"';
	$btnRemoveClass    = 'class="btn btn-danger btnRemoveAnexo"';

	$headerPlaceholder = 'placeholder="Insira um texto acima da imagem."';
	$headerName 	   = 'name="header_anexo_'.$code.'"';

	$footerPlaceholder = 'placeholder="Insira um texto abaixo da imagem."';
	$footerName 	   = 'name="footer_anexo_'.$code.'"';

	$inputFile 	       = 'id="anexo_'.$code.'" name="anexo_'.$code.'"';

	if(!isset($anexo_id)) $anexo_id = '';
	if(!isset($anexo_dir)) $anexo_dir = DIR_PAGE.'public/default-placeholder.png';
	if(!isset($anexo_header)) $anexo_header = '';
	if(!isset($anexo_footer)) $anexo_footer = '';

	$id_image = explode('_',$code)[1];
?>
<div class="col-xs-6 col-sm-6 col-md-6 div_container_anexo" id="div_<?= $code; ?>">
	<div class="col-md-12 div_anexo text-center">

		<button type="button"
				<?= $btnRemoveClass ?> 
				value="<?= $code; ?>" 
				<?= $btnRemoveID; ?> >
			<span class="fa fa-trash"></span>
		</button>

		<textarea 
			class="form-control" 
			<?= $headerName ?> 
			<?= $headerPlaceholder ?>/><?= $anexo_header; ?></textarea>

		<img class="img_anexo" src="<?= $anexo_dir; ?>" id="img_anexo_<?= $code; ?>">
		<textarea 
			class="form-control" 
			<?= $footerName; ?> 
			<?= $footerPlaceholder ?> 
			/><?= $anexo_footer; ?></textarea>

		<button type="button" class="btn btn-info btn-block btnAnexoFile" value="<?= $code; ?>">
			Enviar Imagem
		</button>
		<input 
			type="hidden" 
			id="id_anexo_<?= $code; ?>" 
			name="id_anexo_<?= $code; ?>" 
			value="<?= $anexo_id; ?>">

			<input type="hidden" name="indice_anexo_<?= $itemId; ?>[]" value="<?= $anexo_id; ?>">
			
		<input class="inpt_anexo"  <?= $inputFile; ?>  type="file" style="display:none">
	</div>
</div>