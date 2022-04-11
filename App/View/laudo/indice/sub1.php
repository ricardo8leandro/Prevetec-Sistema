<ul class="ul-sumario sumario-sub1">
<?php 
	if(is_array($item['child'])){
	foreach($item['child'] as $k2 => $subitem){
		$url_link = PAINEL."modelo-laudo/item/editar/";
        $url_link .= $subitem['cd_laudo_item'];
        $id_item = $subitem['cd_laudo_item'];
?>                                
	<li 
        class="li-indice-model-laudo"
        item_id="<?= $id_item; ?>"
        data-id="<?= $k2; ?>" 
        id="item_<?= $id_item; ?>" 
        indice="<?= $subitem['indice']?>">

        <?= $subitem['ds_titulo']; ?>


        <a class="btnDelete li-indice-link" value="<?= $id_item; ?>" >
            <i class="fa fa-trash"></i>
        </a>

       <a 
        class="li-indice-link"
        target="_blank"
        href="<?= $url_link; ?>">
           ver conteudo
       </a>
<?php
		if(isset($subitem['child'])) include DIR_REQ.'App/View/laudo/indice/sub2.php';
	
	}
}
?>
</ul>