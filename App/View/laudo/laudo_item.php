<?php 
    $titulo       = "";
    $descricao  = "";
    $formId     = "formCadastrar";
    $inputName  = "novoLaudoItem";
    $btn        = "Criar";
    $conteudo   = "";
    $editavel   = "";
    $parent     = ""; 

    if(isset($this->list['editar']) && is_array($this->list['editar'])){
        $inputName  = "editLaudoItem";
        $status     = 0;
        $formId     = "formEditar";
        $id         = $this->list['editar']['cd_laudo_item'];
        $titulo     = $this->list['editar']['ds_titulo'];
        $status     = $this->list['editar']['ic_status'];
        $conteudo   = $this->list['editar']['ds_conteudo'];
        $parent     = $this->list['editar']['parent'];

        //por enquanto este campo nao faz nada no sistema. 
        $editavel = $this->list['editar']['ic_editavel'];
        $item_laudo_modelo = $this->list['editar']['id_laudo_modelo'];
        $btn = "Atualizar";
    }

    $modelo = $this->list['modelo'];
    $itens  = $this->list['itens'];
?>

<div class="panel panel-default">
    <div class="panel-heading"><?= $this->getTitle(); ?></div>
    <div class="panel-body">

    	<form method="post" class="form-horizontal" action="" id="<?= $formId; ?>">
            <div class="form-group">
                <label class="col-lg-3 control-label" for="titulo">Modelo de Laudo</label>
                <div class="col-lg-6">
                    <input type="text" class="form-control" value="<?= $modelo['nm_laudo_modelo']; ?>" disabled/>
                </div>
            </div>

            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-3 control-label" for="titulo">Titulo</label>
                <div class="col-lg-6">
                    <input type="text" class="form-control" name="titulo" id="titulo" value="<?= $titulo; ?>" required/>
                </div>
            </div>


            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-3 control-label" for="parent">Item pai</label>
                <div class="col-lg-6">
                    <select class="form-control" name="parent" id="parent" required>
                        <option selected value="0">Este item não possui um pai</option>

                        <?php 
                            foreach($itens as $k1 => $item){

                                if($id == $item['cd_laudo_item']) continue;

                                $selected = "";

                                if($item['cd_laudo_item'] == $parent) $selected = "selected";
                                
                        ?>
                            <option value="<?= $item['cd_laudo_item']; ?>" <?= $selected; ?> >
                                <?= $k1+1; ?>.
                                <?= $item['ds_titulo']; ?>
                            </option>

                            <?php 
                            if(is_array($item['child']) && count($item['child'])){
                                foreach($item['child'] as $k2 => $subitem){
                                    
                                    if($id == $subitem['cd_laudo_item']) continue;
                                    
                                    $selected = "";

                                    if($subitem['cd_laudo_item'] == $parent) $selected = "selected";
                            ?>
                                <option value="<?= $subitem['cd_laudo_item']; ?>" <?= $selected; ?> >
                                    &nbsp; &nbsp; <?= $k1+1; ?>.<?= $k2+1; ?>.
                                    <?= $subitem['ds_titulo']; ?>
                                </option>
                            <?php }}  ?>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-3 control-label" for="status">Situação</label>
                <div class="col-lg-6">
                    <select class="form-control" name="status" id="status" required>
                        <option selected disabled>Selecione uma opção</option>
                        <option value="ativo" <?php if(isset($status) && $status == 'ativo') echo "selected"; ?>>
                         Ativo 
                        </option>
                        <option value="inativo" <?php if(isset($status) && $status == 'inativo') echo "selected"; ?>>
                         Inativo 
                        </option>
                    </select>
                </div>
            </div>

            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-1" for="">Conteudo</label>
                <div class="col-lg-12">
                    <textarea id='conteudo' name="conteudo"><?= $conteudo; ?></textarea>
                    <?php load_editor(WYSIWYG_NAME,'conteudo'); ?>
                </div>
            </div>

            <hr class="dotted">
        	<div class="form-group">
                <div class="col-sm-offset-4 col-sm-5">
                    <input type="hidden" name="<?= $inputName; ?>" value="1">
                    <?php if(isset($id)){ ?>
                        <input type="hidden" name="id" value="<?= $id; ?>" >
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
    var url_cad_edit = "modelo-laudo/item/";
</script>