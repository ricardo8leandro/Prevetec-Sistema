<?php 
function load_item_content($item, $key){
	$cd_item = $item['cd_laudo_item'];
    ?>

    <hr class="dotted">
        <div class="form-group">
            <label class="col-lg-12" for=""><?= $item['ds_titulo']; ?></label>
            <div class="col-lg-12">
                <textarea
                id="laudo_item"
                name="laudo_item_<?= $key; ?>_<?= $cd_item; ?>"><?= $item['ds_conteudo']; ?></textarea>
            </div>                

			    <div class="col-lg-12 anexo_container sortable sort-list anexos-container" id="anexos_<?= $cd_item; ?>">

                    <br>
			        <?php 
		            if(isset($item['anexos']) && is_array($item['anexos'])){
		                foreach($item['anexos'] as $k => $anexo){                    
		                    $anexo_id = $anexo['cd_laudo_item_anexo'];
		                    $code = $cd_item."_".$k;
		                    $anexo_dir = DIR_PAGE.'public/laudosPDF/anexo_items';
		                    $anexo_dir .= "/".$cd_item."/".$anexo['nm_anexo'];
		                    $anexo_header = $anexo['ds_cabecalho'];
		                    $anexo_footer = $anexo['ds_rodape'];

		                    include DIR_VIEW.'laudo/estrutura_anexo.php';

		                    ?>
		                    <script type="text/javascript">
		                        if(typeof nrAnexosPorDiv[<?= $cd_item ?>] !== 'undefined'){
		                            nrAnexosPorDiv[<?= $cd_item ?>] = eval(nrAnexosPorDiv[<?= $cd_item ?>] + 1);
		                        }else{
		                          nrAnexosPorDiv[<?= $cd_item ?>] = 1;
		                        }
		                    </script>
		                    <?php
		                }
		            }
			        ?>
			    </div>
			<!-- </div> -->

            <div class="col-lg-12">
            	adicione a variavel {{ANEXOS}} dentro do editor onde queira adicionar anexos ao texto
                <button 
                    class="btn btn-info btnAddImage" 
                    value="<?= $cd_item; ?>" 
                    style="float:right"
                    type="button">
                    Adicionar Imagem
                </button>
            </div>
            <?php load_editor(WYSIWYG_NAME,'laudo_item'); ?>
        </div>
    <?php
}

function load_item_title($item, $key){
    ?>
    <hr class="dotted">
        <div class="form-group">
            <div class="col-sm-6 col-sm-offset-3">
                <button type="button" value="<?= $key; ?>" class="btnItem btn btn-info btn-block">
                	<?= $item['ds_titulo']; ?>
                </button>
            </div>
        </div>
    <?php
}

function load_pdf_title($pdf){

}

function load_pdf_content($pdf){
    $path_cert_pdf  = "";
    $path_cert_pdf1 = "";
    $path_cert_pdf2 = "";

    if(file_exists($pdf['file'])) $path_cert_pdf = $pdf['link'];

    if($pdf['ds_titulo'] != 'ART'){
        
        if(file_exists(DIR_REQ.'public/laudosPDF/cert1.pdf')){
            $path_cert_pdf1 = DIR_PAGE.'public/laudosPDF/cert1.pdf';
        }
        
        if(file_exists(DIR_REQ.'public/laudosPDF/cert2.pdf')){
            $path_cert_pdf2 = DIR_PAGE.'public/laudosPDF/cert2.pdf';
        }

    }
?>
    <hr class="dotted">
    <div class="form-group">
        <div class="col-sm-12 text-center">
            <h3><?= $pdf['ds_titulo'] ?></h3>

            <?php if($pdf['ds_titulo'] == 'ART'){ ?>
                <div style="clear:both">
                   <iframe id="pdf_viewer" frameborder="0" scrolling="no" ></iframe>
                </div>
            <?php }else{ ?>
            
                <div style="clear:both">
                   <iframe id="pdf_viewer1" frameborder="0" scrolling="no" ></iframe>
                </div>
                <div style="clear:both">
                   <iframe id="pdf_viewer2" frameborder="0" scrolling="no" ></iframe>
                </div>
            
            <?php }?>

            <?php if($pdf['ds_titulo'] == 'ART'){ ?>
                <input type="file" name="art" id="art"  onchange="PreviewImage();" style="display:none">
                <br>
                <div class="col-sm-offset-4 col-sm-4">
                    <button type="button" id="btnAddArt" class="btn btn-warning btn-block" >
                        Adicionar anexos ART
                    </button>
                </div> 
            <?php } ?>
        </div>
    </div>

    <?php if($pdf['ds_titulo'] == 'ART'){ ?>
        <script type="text/javascript">
            var url_cert_pdf = '';
            url_cert_pdf  = <?= "'".$path_cert_pdf."'"; ?>;
            if(url_cert_pdf != '') $('#pdf_viewer').attr('src',url_cert_pdf);
        </script>
    <?php }else{ ?>
        <script type="text/javascript">
            var url_cert_pdf1 = '';
            url_cert_pdf1  = <?= "'".$path_cert_pdf1."'"; ?>;
            if(url_cert_pdf1 != '') $('#pdf_viewer1').attr('src',url_cert_pdf1);

            var url_cert_pdf2 = '';
            url_cert_pdf2  = <?= "'".$path_cert_pdf2."'"; ?>;
            if(url_cert_pdf2 != '') $('#pdf_viewer2').attr('src',url_cert_pdf2);
        </script>
    <?php } ?>
<?php

}