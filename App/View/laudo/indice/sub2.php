<ul class="ul-sumario sumario-sub2">
<?php 
	if(is_array($subitem['child'])){
	foreach($subitem['child'] as $k3 => $subitem2){
		$url_link = PAINEL."modelo-laudo/item/editar/";
        $url_link .= $subitem2['cd_laudo_item'];
        $id_item = $subitem2['cd_laudo_item'];
?>                                
	<li 
        class="li-indice-model-laudo"
        item_id="<?= $id_item; ?>"
        data-id="<?= $k3; ?>" 
        id="item_<?= $id_item; ?>" 
        indice="<?= $subitem2['indice']?>">

        <?= $subitem2['ds_titulo']; ?>


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
	}
}
?>
</ul>