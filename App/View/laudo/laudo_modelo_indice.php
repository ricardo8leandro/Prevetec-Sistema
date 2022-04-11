<?php 
    $formId     = "formCadastrar";
    $inputName  = "editOrdemIndice";
    $btn        = "Salvar";

    $modelo     = $this->list['modelo'];
    $id_laudo   = $modelo['cd_laudo_modelo']; 
    $itens      = $this->list['itens']; 

?>
<div class="panel panel-default">
    <div class="panel-heading"><?= $modelo['nm_laudo_modelo']; ?></div>

    <div class="panel-body">
    
    	<form method="post" class="form-horizontal" action="" id="formOrdenarIndice">
         
            <div class="form-group">
                <div class="col-sm-12 text-center bg-white">
                    <h2>SUMÁRIO</h2>    
                </div>
                <div class="col-lg-10 col-lg-offset-1">
                    
                    
                    <ul class="ul-sumario sumario-titulo">
                        
                    <?php 
                    if(is_array($itens)){
                        foreach($itens as $key => $item){
                            $url_link = PAINEL."modelo-laudo/item/editar/";
                            $url_link .= $item['cd_laudo_item'];
                            $id_item = $item['cd_laudo_item'];
                    ?>
                        <li 
                            class="li-indice-model-laudo panel panel-info"
                            item_id="<?= $id_item; ?>"
                            data-id="<?= $key; ?>" 
                            id="item_<?= $id_item; ?>" 
                            indice="<?= $item['indice']?>">
                            
                            <div class="panel-heading">
                                <?= $item['ds_titulo']; ?>
                            


                            <a class="btnDelete li-indice-link" value="<?= $id_item; ?>" >
                                <i class="fa fa-trash"></i>
                            </a>

                           <a 
                            class="li-indice-link"
                            target="_blank"
                            href="<?= $url_link; ?>">
                               ver conteudo
                           </a>

                            </div>
                            <div class="panel-body">
                    <?php 
                            if(isset($item['child'])){
                                include DIR_REQ.'App/View/laudo/indice/sub1.php';    
                            }
                            
                            echo "</div></li>";
                        }
                    }
                    ?>

                    </ul>
                </div>
            </div>
        
        	<div class="form-group">
            <div class="col-sm-offset-4 col-sm-4">
            <input type="hidden" name="<?= $inputName; ?>" value="1">
                <?php if(isset($id_laudo)){ ?>
                    <input type="hidden" name="id" id="id_laudo" value="<?= $id_laudo; ?>" >
                <?php } ?>
                <button type="submit" class="btn btn-success form-control btnSubmit">
                    <?= $btn; ?>
                </button>
            </div>
        	</div>
        
    	</form>
    </div>
</div>
<script type="text/javascript">
    var url_cad_edit = "modelo-laudo/";
    var url_delete = "<?= PAINEL.'modelo-laudo/item/excluir';?>";
</script>