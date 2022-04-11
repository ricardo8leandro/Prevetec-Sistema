<?php
	function load_editor_link($editor,$api_key){
		$editor .= "_link";
		if(function_exists($editor))$editor($api_key);
	}

	/*scripts das libs */
	function tinymce_link($api_key){
		$api_url = 'https://cdn.tiny.cloud/1/'.$api_key.'/tinymce/5/tinymce.min.js';
		?>
			<script src="<?= $api_url; ?>" referrerpolicy="origin"></script>
		<?php
	}

	/*tinymce versão gratuita. */
	function tinymce_free_link($api_key){
		?>
			<script src="http://tinymce.cachefly.net/4.0/tinymce.min.js"></script>
		<?php
	}

	function ckeditor_link($api_key){
		?>
		<script src="//cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
		<!-- <script src="<?= DIR_TEMPLATE; ?>assets/js/plugins/ckeditor/ckeditor.js"></script>
        <script src="<?= DIR_TEMPLATE; ?>assets/js/plugins/ckeditor/adapters/jquery.js"></script> -->
        <script src="<?= DIR_PAGE; ?>public/nanospell/autoload.js"></script>
        <?php
	}