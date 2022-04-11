<?php 
    $nome = "";
    $descricao = "";
    $formId = "formCadastrar";
    $inputName = "novoEdificio";
    $btn = "Criar";

    if(isset($this->list['editar']) && is_array($this->list['editar'])){
        $inputName = "editEdificio";
        $status = 0;
        $formId = "formEditar";
        $id = $this->list['editar']['cd_tipo_edificio'];
        $nome = $this->list['editar']['ds_titulo'];
        $status = $this->list['editar']['cd_situacao'];

        $btn = "Atualizar";
    }
?>
<div class="panel panel-default">
    <div class="panel-heading"><?= $this->getTitle(); ?></div>
    <div class="panel-body">
    	<form method="post" class="form-horizontal" action="" id="<?= $formId; ?>">
            <div class="form-group">
                <label class="col-lg-4 control-label" for="nome">Titulo</label>
                <div class="col-lg-5">
                    <input type="text" class="form-control" name="nome" id="nome" value="<?= $nome; ?>" required/>
                </div>
            </div>

            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-4 control-label" for="status">Situação</label>
                <div class="col-lg-5">
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
    var url_cad_edit = "edificio/";
</script>