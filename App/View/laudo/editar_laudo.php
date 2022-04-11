<?php
    include_once 'functions.php';

	$laudo = $this->list['editar']; 
	$cd_laudo = $laudo['cd_laudo'];
	$laudo_pdf  = $laudo['ds_path_laudo_pdf'];
	$itens = $this->list['itens'];
?>

<!-- sortable -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $( function() {
        $(".sortable").sortable();
        $(".sortable").disableSelection();
    });
</script>
<!--  -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.2.228/pdf.min.js"></script>
<script type="text/javascript">
    var nrAnexosPorDiv = [];
</script>
<div class="panel panel-default">
    <div class="panel-heading"><?= $this->getTitle(); ?></div>
    <div class="panel-body">
    	<form 
            method="post" class="form-horizontal" 
            action="<?= PAINEL.'laudo/laudo/'.$cd_laudo; ?>" 
            id="formLaudoConteudo"
            enctype="multipart/form-data">
    		<?php
            
            $nrCampos = 0;

            if(is_array($itens)){ 

                foreach($itens as $key => $item){
                    $nrCampos++;
                    $form_action = PAINEL."laudo/laudo/".$cd_laudo."/".$key;

                    if(isset($item['is_active'])){

                        if($item['ds_titulo'] == 'CERTIFICADO' || $item['ds_titulo'] == "ART"){
                            load_pdf_content($item, $key + 1);
                        }else{
                            load_item_content($item, $key + 1);
                        }

                    }else{
                        load_item_title($item, $key + 1);
                    }
                }
            } 
            
            if(!empty($laudo_pdf)){ 

            	$laudo_pdf = DIR_LAUDO_PDF . $laudo_pdf;

            ?>
            	<hr class="dotted">
	            <div class="form-group">
	            	<div class="col-sm-6 col-sm-offset-3">
	            		<div class="col-sm-6">
			    			<a  href="<?= $laudo_pdf; ?>" target="_blank">
								<button type="button" class="btn btn-info btn-block" >
									Visualizar PDF
								</button>
							</a>
			    		</div>

			    		<div class="col-sm-6">
			    			<a id="baixarPDF" href="<?= $laudo_pdf; ?>" download>
								<button type="button" class="btn btn-info btn-block">
									Baixar PDF
								</button>
							</a>
			    		</div>
	            	</div>
	            </div>
            <?php } ?>

            <hr class="dotted">
        	<div class="form-group">
                <div class="col-sm-offset-4 col-sm-4">
                    <button type="button" class="btn btn-success btn-block" id="btnFormLaudo">
                    	Salvar
                    </button>
                </div>
        	</div>
    	</form>
    </div>
</div>

<style type="text/css">
    .cke_contents{
        min-height:350px !important;
    }

    .anexos img{
        width:100%;
        margin-bottom:15px;
        border: 1px solid #999;
    }

    #pdf_viewer,#pdf_viewer1,#pdf_viewer2{
        width:100%;
        height:600px;
    }

    .img_anexo{
        max-width:100%;
        height:200px;
        margin-top:10px;
        margin-bottom:10px;
    }

    .div_anexo{
        border: 1px solid #888;
        border-radius: 8px;
    }

    .btnRemoveAnexo{
        right: 20px;
        float:right;
    }

    .btnAnexoFile{
        margin-top:10px;
        margin-bottom:10px;
    }

    .btnRemoveAnexo{
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .div_container_anexo{
        margin-bottom:15px;
        
    }
    
    .anexos-container{
        width: 101%;
    }
</style>

<script type="text/javascript">
    var form_action_base = $('#formLaudoConteudo').attr('action');

    $(document).on('click','.btnItem',function(){
        let item = $(this).attr('value');
        $('#formLaudoConteudo').attr('action', form_action_base +'/'+item);
        $('#formLaudoConteudo').trigger('submit');
    });

    $(document).on('click','#btnFormLaudo',function(){
        $('#formLaudoConteudo').attr('action', form_action_base +'/salvar');
        $('#formLaudoConteudo').trigger('submit'); 
    });

    var actionStatus = <?= $this->list['actionStatus']; ?>;
    var nrCampos = <?= $nrCampos; ?>;

    function PreviewImage() {
        pdffile     = document.getElementById('art').files[0];
        pdffile_url = URL.createObjectURL(pdffile);
        $('#pdf_viewer').attr('src',pdffile_url);
    }
</script>