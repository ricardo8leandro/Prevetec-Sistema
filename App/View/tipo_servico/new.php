<?php 
    $titulo = "";
    $descricao = "";
    $formId = "formCadastrar";
    $inputName = "novoTipoServico";
    $btn = "Criar";
    $conteudo = "";
    $configPDF = '';
    $PDFs = isset($this->list['configPDFs'])? $this->list['configPDFs'] : null;

    if(isset($this->list['editar']) && is_array($this->list['editar'])){
        $inputName = "editTipoServico";
        $status = 0;
        $formId = "formEditar";
        $id = $this->list['editar']['cd_tipo_servico'];
        $titulo = $this->list['editar']['ds_titulo'];
        $status = $this->list['editar']['cd_situacao'];
        $conteudo = $this->list['editar']['ds_descricao'];
        $configPDF = $this->list['editar']['cd_pdf_config'];
        $btn = "Atualizar";
    }
?>
<div class="panel panel-default">
    <div class="panel-heading"><?= $this->getTitle(); ?></div>
    <div class="panel-body">

    	<form method="post" class="form-horizontal" action="" id="<?= $formId; ?>" >
            <div class="form-group">
                <label class="col-lg-1" for="titulo">Titulo</label>
                <div class="col-lg-12">
                    <input type="text" class="form-control" name="titulo" id="titulo" value="<?= $titulo; ?>" required/>
                </div>
            </div>

            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-6 " for="status">Configuração de PDF</label>
                <div class="col-lg-12">
                    <select class="form-control" name="ConfigPDF" id="ConfigPDF" required>
                        <option selected disabled>Selecione uma opção</option>
                        <?php
                        foreach ($PDFs as $key => $pdf){
                            $selected = ""; 
                            if($pdf['cd_pdf_config'] == $configPDF)$selected = "selected";
                        ?>
                            <option value="<?= $pdf['cd_pdf_config']; ?>" <?= $selected; ?> >
                                <?= $pdf['ds_titulo']; ?>
                            </option>
                        <?php }?>
                    </select>
                </div>
            </div>

            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-1 " for="status">Situação</label>
                <div class="col-lg-12">
                    <select class="form-control" name="status" id="status" required>
                        <option selected disabled>Selecione uma opção</option>
                        <option value="1" <?php if(isset($status) && $status == 1) echo "selected"; ?>>
                         Ativo 
                        </option>
                        <option value="0" <?php if(isset($status) && $status == 0) echo "selected"; ?>>
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
                    <button type="submit" class="btn btn-success form-control"><?= $btn; ?></button>
                </div>
        	</div>
    	</form>
    </div>
</div>
<script type="text/javascript">
    var url_cad_edit = "tipo-servico/";
</script>