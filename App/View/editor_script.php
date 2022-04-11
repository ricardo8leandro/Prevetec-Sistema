<?php 
	
	/* function para montar o editor. */
	function load_editor($editor, $name){
		if(function_exists($editor)) $editor($name);
	}

	function tinymce($element_id){
		?>
		<script>
	        tinymce.init({
	          selector: '#<?= $element_id; ?>',
	          plugins: 'a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
	          toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
	          toolbar_mode: 'floating',
	          tinycomments_mode: 'embedded',
	          tinycomments_author: 'Prevetec',
	          height: '500',
	          language : 'pt',
	        });
	      </script>
		<?php
	}

	function tinymce_free($element_id){
		?>
		<script>
	       var mypath = <?= "'".DIR_PAGE."'"?> +"nanospell/plugin.js";

		    tinymce.init({
		        selector: '#<?= $element_id; ?>',
		        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak table',
		        toolbar_mode: 'floating',
		        selector: "textarea",
		        external_plugins: {"nanospell": mypath},
		        nanospell_server: "php",
		        height: '500',
		    });
	      </script>
		<?php
	}

	function ckeditor($element_id){
		?>
		<script>			
			$(document).ready(function(){
				CKEDITOR.replace(<?= "'".$element_id."'"; ?>,{
					filebrowserBrowseUrl: PAINEL + 'files/browse/',
					filebrowserUploadUrl: PAINEL + 'files/upload/',
					height:500
				});

		        nanospell.ckeditor(<?= "'".$element_id."'"; ?>,{
		        dictionary : "pt_br",
		        server : "php" });
		    });
		</script>
		<?php
	}