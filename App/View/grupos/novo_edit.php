<?php 
    $disabled = "";
    $nome = "";
    $descricao = "";
    $formId = "formCadastrar";
    $inputName = "novoGrupo";
    $btn = "Criar";
    $p = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];

    if(isset($this->list['editar']) && is_array($this->list['editar'])){
        $disabled = "disabled";
        $inputName = "editGrupo";
        $status = 0;
        $formId = "formEditar";
        $id = $this->list['editar']['cd_grupo'];
        $nome = $this->list['editar']['nm_grupo'];
        $status = $this->list['editar']['status_grupo'];
        $descricao = $this->list['editar']['ds_grupo'];

        $btn = "Atualizar";

        if(is_array($this->list['permissoes'])){
            foreach($this->list['permissoes'] as $key => $value){
                $p[$key] = $value['nivel_acesso'];
            }    
        }
    }
?>

<div class="panel panel-default">
    <div class="panel-heading"><?= $this->getTitle(); ?></div>
    <div class="panel-body">
    	<form method="post" class="form-horizontal" action="" id="<?= $formId; ?>">
            <div class="form-group">
                <label class="col-lg-4 control-label" for="tipo_usuario">Nome do grupo</label>
                <div class="col-lg-5">
                    <input type="text" <?= $disabled; ?> class="form-control" 
                    name="nome" id="tipo_usuario" value="<?= $nome; ?>" required/>
                </div>
            </div>

            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-4 control-label" for="tipo_usuario">Situação</label>
                <div class="col-lg-5">
                    <select class="form-control" name="status" required>
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
                <label class="col-lg-4 control-label" for="descricao">Descrição</label>
                <div class="col-lg-5">
                   <input type="text" class="form-control" name="descricao" id="descricao" 
                        value="<?= $descricao; ?>" required/>
                </div>
            </div>

            <hr class="dotted">
            <div class="form-group">
                <label class="col-lg-4 control-label">Selecione as permissões que este<br>
                tipo de usuário terá nos seguintes módulos</label>
                <div class="col-lg-4">
                </div>
            </div>

            <?php 
                if(isset($this->list['modulos']) && is_array($this->list['modulos'])){
                    foreach($this->list['modulos'] as $key => $value){
            ?>
            <div class="form-group">
                <label class="col-lg-4 control-label"><?= $value['nm_modulo']; ?></label>
                <div class="col-lg-5">
                    <?php if($value['nm_modulo'] != 'chat'){ ?>
                    <div class="checkbox">
                        <label>
                            <input type="radio" name="radio_<?= $value['cd_modulo']?>" value="0"
                            <?php if($p[$key] == 0 || $p[$key] == null) echo 'checked'; ?> /> nada
                        </label>
                        <label>
                            <input type="radio" name="radio_<?= $value['cd_modulo']?>" value="1" 
                            <?php if($p[$key] == 1 ) echo 'checked'; ?> /> Visualizar
                        </label>
                        <label>
                            <input type="radio" name="radio_<?= $value['cd_modulo']?>" value="2"
                            <?php if($p[$key] == 2 ) echo 'checked'; ?> /> Criar
                        </label>
                        <label>
                            <input type="radio" name="radio_<?= $value['cd_modulo']?>" value="3"
                            <?php if($p[$key] == 3 ) echo 'checked'; ?> /> Editar
                        </label>
                        <label>
                            <input type="radio" name="radio_<?= $value['cd_modulo']?>" value="4"
                            <?php if($p[$key] == 4 ) echo 'checked'; ?> /> Tudo
                        </label>
                    </div>
                    <?php }else{ ?>
                        <div class="checkbox">
                        <label>
                            <input type="radio" name="radio_<?= $value['cd_modulo']?>" value="0"
                            <?php if($p[$key] == 0 || $p[$key] == null) echo 'checked'; ?> /> Desabilitado
                        </label>
                        <label>
                            <input type="radio" name="radio_<?= $value['cd_modulo']?>" value="1" 
                            <?php if($p[$key] == 1 ) echo 'checked'; ?> /> Habilitado
                        </label>
                    </div>
                    <?php } ?>
                </div>
            </div>

            <hr class="dotted">
            <?php }} ?>        

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
    var url_cad_edit = "grupos/";
</script>